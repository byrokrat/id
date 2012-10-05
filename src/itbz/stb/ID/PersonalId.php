<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb\ID
 */

namespace itbz\stb\ID;

use itbz\stb\Utils\Modulo10;
use itbz\stb\Exception\InvalidStructureException;
use itbz\stb\Exception\InvalidCheckDigitException;
use DateTime;

/**
 * Swedish personal identity numbers
 *
 * @package stb\ID
 */
class PersonalId
{
    /**
     * Date of birth
     *
     * @var DateTime
     */
    private $date;

    /**
     * Individual number
     *
     * @var string
     */
    private $individualNr = '';

    /**
     * Check digit
     *
     * @var string
     */
    private $check = '';

    /**
     * Date and control string delimiter, - or +
     *
     * @var string
     */
    private $delim = '';

    /**
     * Construct and set id number
     *
     * @param string $id
     */
    public function __construct($id = '')
    {
        if ($id) {
            $this->setId($id);
        }
    }

    /**
     * Set id number
     *
     * Format is YYYMMDD(.)NNNC or YYMMDD(+-)NNNC where parenthesis represents a
     * one char delimiter, N represents the individual number and C the check
     * digit. If year is set using two digits century is calculated based on
     * delimiter (+ signals more than a hundred years old). If year is set using
     * four digits delimiter is calculated based on century.
     *
     * @param string $id
     *
     * @return void
     *
     * @throws InvalidStructureException if structure is invalid
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function setId($id)
    {
        assert('is_string($id)');

        $split = preg_split("/([-+])/", $id, 2, PREG_SPLIT_DELIM_CAPTURE);
        if ( count($split) != 3 ) {
            $msg = 'IDs must use form (NN)NNNNNN-NNNN or (NN)NNNNNN+NNNN';
            throw new InvalidStructureException($msg);
        }

        $datestr = $split[0];
        $this->setDelimiter($split[1]);

        if (!ctype_digit($datestr)) {
            throw new InvalidStructureException('The parsed date was invalid');
        }

        if (strlen($datestr) == 6) {
            // Six digit date. Calculate century based on delimiter
            $date = DateTime::createFromFormat('ymd', $datestr);
            $dateerrors = DateTime::getLastErrors();
            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $date->modify('-100 year');
            }
            $this->setDate($date);

        } elseif (strlen($datestr) == 8) {
            // Eight digit date. Set delimiter based on date.
            $this->setDate(DateTime::createFromFormat('Ymd', $datestr));
            $dateerrors = DateTime::getLastErrors();
            // Delimiter should be + if date is more then a hundred years old
            $century = new DateTime();
            $century->modify('-100 year');
            if ($this->getDate() < $century) {
                $this->setDelimiter('+');
            } else {
                $this->setDelimiter('-');
            }

        } else {
            // Invalid date string length
            throw new InvalidStructureException('The parsed date was invalid');
        }

        // Check if there was an error parsing date
        $errors = implode(', ', $dateerrors['errors']);
        $errors .= ' ' . implode(', ', $dateerrors['warnings']);
        $errors = trim($errors);
        if (!empty($errors)) {
            throw new InvalidStructureException($errors);
        }

        // Validate check digit
        $control = $split[2];
        if (strlen($control) != 4 || !ctype_digit($control)) {
            $msg = 'Unexpected data found. Control number invalid';
            throw new InvalidStructureException($msg);
        }

        $this->setCheckDigit(substr($control, -1));
        $this->setIndividualNr(substr($control, 0, 3));

        $validCheck = $this->calcCheckDigit();
        if ($this->getCheckDigit() != $validCheck) {
            $msg = "Invalid check digit for '$id'";
            throw new InvalidCheckDigitException($msg);
        }
    }

    /**
     * Set date
     * 
     * @param DateTime $date
     *
     * @return void
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
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
     * Set individualNr
     *
     * @param string $individualNr
     *
     * @return void
     */
    public function setIndividualNr($individualNr)
    {
        assert('is_string($individualNr)');
        $this->individualNr = $individualNr;
    }

    /**
     * Get check digit
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
     * @param string $check
     *
     * @return void
     */
    public function setCheckDigit($check)
    {
        assert('is_string($check)');
        $this->check = $check;
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
     * @param string $delim
     *
     * @return void
     */
    public function setDelimiter($delim)
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
     * To string magic method
     *
     * Year represented using four digits
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getDate()->format('Ymd')
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
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
