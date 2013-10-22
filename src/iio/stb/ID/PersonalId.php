<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\ID;

use iio\stb\Utils\Modulo10;
use iio\stb\Exception\InvalidStructureException;
use iio\stb\Exception\InvalidCheckDigitException;
use DateTime;

/**
 * Swedish personal identity numbers
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class PersonalId implements IdInterface
{
    /**
     * @var DateTime Date of birth
     */
    private $date;

    /**
     * @var string Individual number
     */
    private $individualNr;

    /**
     * @var string Check digit
     */
    private $check;

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
     * @param  string                     $id
     * @throws InvalidStructureException  If structure is invalid
     * @throws InvalidCheckDigitException If check digit is invalid
     */
    public function __construct($id)
    {
        if (!preg_match("/^((?:\d\d)?)(\d{6})([-+])(\d{3})(\d)$/", $id, $matches)) {
            throw new InvalidStructureException('Personal ids must use form (XX)XXXXXX-XXXX or (XX)XXXXXX+XXXX');
        }

        list(, $century, $datestr, $delimiter, $individual, $check) = $matches;

        $this->setDelimiter($delimiter);
        $this->setIndividualNr($individual);
        $this->setCheckDigit($check);

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
            throw new InvalidStructureException($errors);
        }

        if ($this->getCheckDigit() != $this->calcCheckDigit()) {
            throw new InvalidCheckDigitException("Invalid check digit for <$id>");
        }
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
     * {@inheritdoc}
     *
     * @return string
     */
    public function getCheckDigit()
    {
        return $this->check;
    }

    /**
     * Set check digit
     *
     * @param  string $check
     * @return void
     */
    protected function setCheckDigit($check)
    {
        assert('is_string($check)');
        $this->check = $check;
    }

    /**
     * {@inheritdoc}
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
     * Get date of birth formatted as YYYY-MM-DD
     *
     * @return string
     */
    public function getDOB()
    {
        return $this->getDate()->format('Y-m-d');
    }

    /**
     * Get sex as denoted by id
     *
     * Returns 'M' for Male or 'F' for Female.
     *
     * @return string
     */
    public function getSex()
    {
        $nr = $this->getIndividualNr();
        $int = intval($nr[2]);

        return ($int%2 == 0) ? 'F' : 'M';
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }

    /**
     * Calculate check digit
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        $nr = $this->getDate()->format('ymd') . $this->getIndividualNr();
        $modulo = new Modulo10();

        return $modulo->getCheckDigit($nr);
    }
}
