<?php

namespace byrokrat\id\Formatter;

use byrokrat\id\IdInterface;

/**
 * Basic formatting functions
 */
trait FormattingFunctions
{
    /**
     * @var string[] Maps tokens to formatting functions
     */
    static protected $tokenMap = [
        self::TOKEN_DATE_CENTURY => 'formatCentury',
        self::TOKEN_SERIAL_PRE => 'formatSerialPre',
        self::TOKEN_SERIAL_POST => 'formatSerialPost',
        self::TOKEN_DELIMITER => 'formatDelimiter',
        self::TOKEN_CHECK_DIGIT => 'formatCheckDigit',
        self::TOKEN_SEX => 'formatSex',
        self::TOKEN_AGE => 'formatAge',
        self::TOKEN_LEGAL_FORM => 'formatLegalForm',
        self::TOKEN_BIRTH_COUNTY => 'formatBirthCounty'
    ];

    /**
     * Format function for century
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatCentury(IdInterface $idObject)
    {
        return $idObject->getCentury();
    }

    /**
     * Format function for serial pre delimiter
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatSerialPre(IdInterface $idObject)
    {
        return $idObject->getSerialPreDelimiter();
    }

    /**
     * Format function for serial post delimiter
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatSerialPost(IdInterface $idObject)
    {
        return $idObject->getSerialPostDelimiter();
    }

    /**
     * Format function for delimiter
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatDelimiter(IdInterface $idObject)
    {
        return $idObject->getDelimiter();
    }

    /**
     * Format function for check digit
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatCheckDigit(IdInterface $idObject)
    {
        return $idObject->getCheckDigit();
    }

    /**
     * Format function for sex
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatSex(IdInterface $idObject)
    {
        return $idObject->getSex();
    }

    /**
     * Format function for age
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatAge(IdInterface $idObject)
    {
        return $idObject->getAge();
    }

    /**
     * Format function for legal form
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatLegalForm(IdInterface $idObject)
    {
        return $idObject->getLegalForm();
    }

    /**
     * Format function for birth county
     *
     * @param  IdInterface $idObject
     * @return string
     */
    static protected function formatBirthCounty(IdInterface $idObject)
    {
        return $idObject->getBirthCounty();
    }
}
