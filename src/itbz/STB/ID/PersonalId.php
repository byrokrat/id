<?php
/**
 * This file is part of the STB package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package STB\ID
 */

namespace itbz\STB\ID;

use itbz\STB\Utils\Modulo10;
use itbz\STB\Exception\InvalidStructureException;
use itbz\STB\Exception\InvalidCheckDigitException;
use DateTime;

/**
 * Swedish personal identity numbers
 *
 * @package STB\ID
 */
class PersonalId
{
    /**
     * Date of birth
     *
     * @var DateTime
     */
    protected $date = '';

    /**
     * Individual number
     *
     * @var string
     */
    protected $individualNr = '';

    /**
     * Check digit
     *
     * @var string
     */
    protected $check = '';

    /**
     * Date and control string delimiter, - or +
     *
     * @var string
     */
    protected $delim = '';

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
        $this->delim = $split[1];

        if (!ctype_digit($datestr)) {
            throw new InvalidStructureException('The parsed date was invalid');
        }

        if (strlen($datestr) == 6) {
            // Six digit date. Calculate century based on delimiter
            $this->date = DateTime::createFromFormat('ymd', $datestr);
            $dateerrors = DateTime::getLastErrors();
            // Date is over a hundred years ago if delimiter is +
            if ($this->delim == '+') {
                $this->date->modify('-100 year');
            }

        } elseif (strlen($datestr) == 8) {
            // Eight digit date. Set delimiter based on date.
            $this->date = DateTime::createFromFormat('Ymd', $datestr);
            $dateerrors = DateTime::getLastErrors();
            // Delimiter should be + if date is more then a hundred years old
            $century = new DateTime();
            $century->modify('-100 year');
            if ($this->date < $century) {
                $this->delim = '+';
            } else {
                $this->delim = '-';
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

        $this->check = substr($control, -1);
        $this->individualNr = substr($control, 0, 3);

        $validCheck = $this->calcCheckDigit();
        if ($this->check != $validCheck) {
            $msg = "Invalid check digit for '$id'";
            throw new InvalidCheckDigitException($msg);
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
     * Get date of birth formatted as YYYY-MM-DD
     *
     * @return string
     */
    public function getDOB()
    {
        return $this->date->format('Y-m-d');
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
        $int = intval($this->individualNr[2]);

        return ( $int%2 == 0 ) ? 'F' : 'M';
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
        return $this->date->format('ymd')
            . $this->delim
            . $this->individualNr
            . $this->check;
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
        return $this->date->format('Ymd')
            . $this->delim
            . $this->individualNr
            . $this->check;
    }

    /**
     * Calculate check digit
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        $nr = $this->date->format('ymd') . $this->individualNr;
        $modulo = new Modulo10();

        return $modulo->getCheckDigit($nr);
    }
}
