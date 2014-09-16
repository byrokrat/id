<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

use DateTime;

/**
 * Swedish personal identity numbers
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class PersonalId implements Id
{
    use Component\Structure, Component\CheckDigit, Component\SexualIdentity, Component\Stringify;

    /**
     * @var string Regular expression describing structure
     */
    protected static $structure = '/^((?:\d\d)?)(\d{6})([-+])(\d{3})(\d)$/';

    /**
     * @var DateTime Date of birth
     */
    private $date;

    /**
     * @var string Individual number
     */
    private $individualNr;

    /**
     * @var string Date and control string delimiter (- or +)
     */
    private $delim;

    /**
     * Set id
     *
     * Format is YYYMMDD(+-)NNNC or YYMMDD(+-)NNNC where parenthesis represents a
     * one char delimiter, N represents the individual number and C the check
     * digit. If year is set using two digits century is calculated based on
     * delimiter (+ signals more than a hundred years old). If year is set using
     * four digits delimiter is calculated based on century.
     *
     * @param  string $id
     * @throws Exception\InvalidStructureException  If structure is invalid
     */
    public function __construct($id)
    {
        list(, $century, $datestr, $delimiter, $individual, $check) = PersonalId::parseStructure($id);

        $this->setDelimiter($delimiter);
        $this->setIndividualNr($individual);

        if ($century) {
            // Century specified in $datestr
            $this->setDate(DateTime::createFromFormat('Ymd', $century.$datestr));
            $dateerrors = DateTime::getLastErrors();
            
            // Set delimiter based on date (+ if date is more then a hundred years old)
            $hundredYearsAgo = new DateTime();
            $hundredYearsAgo->modify('-100 year');
            if ($this->getDate() < $hundredYearsAgo) {
                $this->setDelimiter('+');
            } else {
                $this->setDelimiter('-');
            }

        } else {
            // No century in $datestr
            $date = DateTime::createFromFormat('ymd', $datestr);
            
            // If in the future century is wrong
            if ($date > new DateTime) {
                $date->modify('-100 year');
            }

            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $date->modify('-100 year');
            }

            $dateerrors = DateTime::getLastErrors();
            $this->setDate($date);
        }

        // Check if there was an error parsing date
        $errors = implode(', ', $dateerrors['errors']);
        $errors .= ' ' . implode(', ', $dateerrors['warnings']);
        $errors = trim($errors);
        if (!empty($errors)) {
            throw new Exception\InvalidStructureException($errors);
        }

        $this->setCheckDigit($check);
        $this->validateCheckDigit();
    }

    /**
     * Get date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     * 
     * @param  DateTime $date
     * @return void
     */
    protected function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get individualNr
     *
     * @return string
     */
    public function getIndividualNr()
    {
        return $this->individualNr;
    }

    /**
     * Set individualNr
     *
     * @param  string $individualNr
     * @return void
     */
    protected function setIndividualNr($individualNr)
    {
        assert('is_string($individualNr)');
        $this->individualNr = $individualNr;
    }

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delim;
    }

    /**
     * Set delimiter
     *
     * @param  string $delim
     * @return void
     */
    protected function setDelimiter($delim)
    {
        assert('is_string($delim)');
        $this->delim = $delim;
    }

    /**
     * Get sex as denoted by id
     *
     * @return string One of the sex identifier constants
     */
    public function getSex()
    {
        return (intval($this->getIndividualNr()[2])%2 == 0) ? self::SEX_FEMALE : self::SEX_MALE;
    }

    /**
     * Get id
     *
     * Year represented using two digits
     *
     * @return string
     */
    public function getId()
    {
        return $this->getDate()->format('ymd')
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
    }

    /**
     * Get id as long string
     *
     * Year represented using four digits
     *
     * @return string
     */
    public function getLongId()
    {
        return $this->getDate()->format('Ymd')
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
    }

    /**
     * Get date of birth formatted as YYYY-MM-DD
     *
     * @return string
     */
    public function getDOB()
    {
        return $this->getDate()->format('Y-m-d');
    }
}
