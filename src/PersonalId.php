<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

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
    protected static $structure = '/^((?:\d\d)?)(\d{6})([-+]?)(\d{3})(\d)$/';

    /**
     * @var DateTime Date of birth
     */
    protected $date;

    /**
     * @var string Individual number
     */
    protected $individualNr;

    /**
     * @var string Date and control string delimiter (- or +)
     */
    protected $delimiter;

    /**
     * Set id
     *
     * Format is YYYMMDD(+-)NNNC or YYMMDD(+-)NNNC where parenthesis represents a
     * one char delimiter, N represents the individual number and C the check
     * digit. If year is set using two digits century is calculated based on
     * delimiter (+ signals more than a hundred years old). If year is set using
     * four digits delimiter is calculated based on century.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        list(, $century, $datestr, $delimiter, $this->individualNr, $check) = PersonalId::parseStructure($id);

        $this->delimiter = $delimiter ?: '-';

        if ($century) {
            // Set delimiter based on date (+ if date is more then a hundred years old)
            $this->date = DateTime::createFromFormat('Ymd', $century.$datestr);
            $hundredYearsAgo = new DateTime();
            $hundredYearsAgo->modify('-100 year');
            $this->delimiter = $this->getDate() < $hundredYearsAgo ? '+' : '-';
        } else {
            // No century in $datestr
            $this->date = DateTime::createFromFormat('ymd', $datestr);
            
            // If in the future century is wrong
            if ($this->date > new DateTime) {
                $this->date->modify('-100 year');
            }

            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $this->date->modify('-100 year');
            }
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
     * Get individualNr
     *
     * @return string
     */
    public function getIndividualNr()
    {
        return $this->individualNr;
    }

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
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
