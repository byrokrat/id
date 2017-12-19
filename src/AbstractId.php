<?php

namespace byrokrat\id;

use byrokrat\id\Exception\DateNotSupportedException;
use byrokrat\id\Exception\InvalidCheckDigitException;
use byrokrat\id\Exception\InvalidStructureException;
use byrokrat\id\Formatter\Formatter;

/**
 * Standard implementation of IdInterface
 */
abstract class AbstractId implements IdInterface
{
    /**
     * @var string Serial number pre delimiter
     */
    protected $serialPre = '000000';

    /**
     * @var string Serial number post delimiter
     */
    protected $serialPost = '000';

    /**
     * @var string Date and control string delimiter (- or +)
     */
    protected $delimiter = '-';

    /**
     * @var string Check digit
     */
    protected $checkDigit = '0';

    public function getId()
    {
        return $this->getSerialPreDelimiter()
            . $this->getDelimiter()
            . $this->getSerialPostDelimiter()
            . $this->getCheckDigit();
    }

    public function __tostring()
    {
        return $this->getId();
    }

    public function format($format)
    {
        return (new Formatter($format))->format($this);
    }

    public function getSerialPreDelimiter()
    {
        return $this->serialPre;
    }

    public function getSerialPostDelimiter()
    {
        return $this->serialPost;
    }

    public function getDelimiter()
    {
        return $this->delimiter;
    }

    public function getCheckDigit()
    {
        return $this->checkDigit;
    }

    public function getBirthDate()
    {
        throw new DateNotSupportedException("Trying to access date on id type where it is not supported");
    }

    public function getDate()
    {
        trigger_error('getDate() is deprecated, use getBirthDate() instead.', E_USER_DEPRECATED);
        return $this->getBirthDate();
    }

    public function getAge(\DateTimeInterface $atDate = null)
    {
        return (int)$this->getBirthDate()->diff($atDate ?: new \DateTime)->format('%y');
    }

    public function getCentury()
    {
        return substr($this->getBirthDate()->format('Y'), 0, 2);
    }

    public function getSex()
    {
        return IdInterface::SEX_UNDEFINED;
    }

    public function isMale()
    {
        return $this->getSex() == IdInterface::SEX_MALE;
    }

    public function isFemale()
    {
        return $this->getSex() == IdInterface::SEX_FEMALE;
    }

    public function isSexUndefined()
    {
        return $this->getSex() == IdInterface::SEX_UNDEFINED;
    }

    public function getBirthCounty()
    {
        return IdInterface::COUNTY_UNDEFINED;
    }

    public function getLegalForm()
    {
        return IdInterface::LEGAL_FORM_UNDEFINED;
    }

    public function isLegalFormUndefined()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_UNDEFINED;
    }

    public function isStateOrParish()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_STATE_PARISH;
    }

    public function isIncorporated()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_INCORPORATED;
    }

    public function isPartnership()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_PARTNERSHIP;
    }

    public function isAssociation()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_ASSOCIATION;
    }

    public function isNonProfit()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_NONPROFIT;
    }

    public function isTradingCompany()
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_TRADING;
    }

    /**
     * Parse id using regular expression
     *
     * @param  string   $regexp
     * @param  string   $raw
     * @return string[] Array of matches
     * @throws InvalidStructureException If regular expression does not match
     */
    protected function parseNumber($regexp, $raw)
    {
        if (!preg_match($regexp, $raw, $matches)) {
            throw new InvalidStructureException("Unable to parse $raw, invalid structure");
        }

        return $matches;
    }

    /**
     * Verify that the last digit of id is a valid check digit
     *
     * @return void
     * @throws InvalidCheckDigitException If check digit is not valid
     */
    protected function validateCheckDigit()
    {
        if (!Modulo10::isValid(preg_replace('/[^0-9]/', '', $this->getId()))) {
            throw new InvalidCheckDigitException("Invalid check digit in {$this->getId()}");
        }
    }
}
