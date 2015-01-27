<?php

namespace byrokrat\id\Formatter;

use byrokrat\id\Id;

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
     * @param  Id $idObject
     * @return string
     */
    static protected function formatCentury(Id $idObject)
    {
        return $idObject->getCentury();
    }

    /**
     * Format function for serial pre delimiter
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatSerialPre(Id $idObject)
    {
        return $idObject->getSerialPreDelimiter();
    }

    /**
     * Format function for serial post delimiter
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatSerialPost(Id $idObject)
    {
        return $idObject->getSerialPostDelimiter();
    }

    /**
     * Format function for delimiter
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatDelimiter(Id $idObject)
    {
        return $idObject->getDelimiter();
    }

    /**
     * Format function for check digit
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatCheckDigit(Id $idObject)
    {
        return $idObject->getCheckDigit();
    }

    /**
     * Format function for sex
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatSex(Id $idObject)
    {
        return $idObject->getSex();
    }

    /**
     * Format function for age
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatAge(Id $idObject)
    {
        return $idObject->getAge();
    }

    /**
     * Format function for legal form
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatLegalForm(Id $idObject)
    {
        return $idObject->getLegalForm();
    }

    /**
     * Format function for birth county
     *
     * @param  Id $idObject
     * @return string
     */
    static protected function formatBirthCounty(Id $idObject)
    {
        return $idObject->getBirthCounty();
    }
}
