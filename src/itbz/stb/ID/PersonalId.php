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
 *
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
    protected $_date = '';


    /**
     * Individual number
     *
     * @var string
     */
    protected $_individualNr = '';


    /**
     * Check digit
     *
     * @var string
     */
    protected $_check = '';


    /**
     * Date and control string delimiter, - or +
     *
     * @var string
     */
    protected $_delim = '';


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
     *
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
        $this->_delim = $split[1];

        if (!ctype_digit($datestr)) {
            throw new InvalidStructureException('The parsed date was invalid');
        }

        if (strlen($datestr) == 6) {
            // Six digit date. Calculate century based on delimiter
            $this->_date = DateTime::createFromFormat('ymd', $datestr);
            $dateerrors = DateTime::getLastErrors();
            // Date is over a hundred years ago if delimiter is +
            if ($this->_delim == '+') {
                $this->_date->modify('-100 year');
            }

        } elseif (strlen($datestr) == 8) {
            // Eight digit date. Set delimiter based on date.
            $this->_date = DateTime::createFromFormat('Ymd', $datestr);
            $dateerrors = DateTime::getLastErrors();
            // Delimiter should be + if date is more then a hundred years old
            $century = new DateTime();
            $century->modify('-100 year');
            if ($this->_date < $century) {
                $this->_delim = '+';
            } else {
                $this->_delim = '-';
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
        
        $this->_check = substr($control, -1);
        $this->_individualNr = substr($control, 0, 3);
        
        $validCheck = $this->calcCheckDigit();
        if ($this->_check != $validCheck) {
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
        return $this->_date;
    }


    /**
     * Get date of birth formatted as YYYY-MM-DD
     *
     * @return string
     */
    public function getDOB()
    {
        return $this->_date->format('Y-m-d');
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
        $int = intval($this->_individualNr[2]);

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
        return $this->_date->format('ymd')
            . $this->_delim
            . $this->_individualNr
            . $this->_check;
    }


    /**
     * To string magic method
     *
     * Year represented using four digits
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->_date->format('Ymd')
            . $this->_delim
            . $this->_individualNr
            . $this->_check;
    }


    /**
     * Calculate check digit
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        $nr = $this->_date->format('ymd') . $this->_individualNr;
        $modulo = new Modulo10();
        
        return $modulo->getCheckDigit($nr);
    }

}
