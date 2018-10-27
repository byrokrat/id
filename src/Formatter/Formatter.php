<?php

declare(strict_types = 1);

namespace byrokrat\id\Formatter;

use byrokrat\id\IdInterface;
use byrokrat\id\Exception\LogicException;

class Formatter implements FormatTokens
{
    /**
     * Map of tokens to formatting function names
     */
    private const TOKEN_MAP = [
        self::TOKEN_DATE_CENTURY => 'formatCentury',
        self::TOKEN_SERIAL_PRE => 'formatSerialPre',
        self::TOKEN_SERIAL_POST => 'formatSerialPost',
        self::TOKEN_DELIMITER => 'formatDelimiter',
        self::TOKEN_CHECK_DIGIT => 'formatCheckDigit',
        self::TOKEN_SEX => 'formatSex',
        self::TOKEN_AGE => 'formatAge',
        self::TOKEN_LEGAL_FORM => 'formatLegalForm',
        self::TOKEN_BIRTH_COUNTY => 'formatBirthCounty',
    ];

    /**
     * @var \Closure Formatting function, takes an Id object and returns a string
     */
    private $formatter;

    /**
     * Create formatter from format string
     */
    public function __construct(string $format = '')
    {
        // Register empty formatting function
        $this->formatter = function () {
            return '';
        };

        // Used to track escaping state
        $escape = '';

        foreach (str_split($format) as $token) {
            switch ($escape . $token) {
                case self::TOKEN_DATE_YEAR_FULL:
                case self::TOKEN_DATE_YEAR:
                case self::TOKEN_DATE_MONTH:
                case self::TOKEN_DATE_MONTH_SHORT:
                case self::TOKEN_DATE_MONTH_TEXT:
                case self::TOKEN_DATE_MONTH_TEXT_SHORT:
                case self::TOKEN_DATE_MONTH_DAYS:
                case self::TOKEN_DATE_WEEK:
                case self::TOKEN_DATE_DAY:
                case self::TOKEN_DATE_DAY_SHORT:
                case self::TOKEN_DATE_DAY_TEXT:
                case self::TOKEN_DATE_DAY_TEST_SHORT:
                case self::TOKEN_DATE_DAY_NUMERIC:
                case self::TOKEN_DATE_DAY_NUMERIC_ISO:
                case self::TOKEN_DATE_DAY_OF_YEAR:
                    $this->registerFormattingFunction(function (IdInterface $idObject) use ($token) {
                        return $idObject->getBirthDate()->format($token);
                    });
                    break;
                case self::TOKEN_DATE_CENTURY:
                case self::TOKEN_SERIAL_PRE:
                case self::TOKEN_SERIAL_POST:
                case self::TOKEN_DELIMITER:
                case self::TOKEN_CHECK_DIGIT:
                case self::TOKEN_SEX:
                case self::TOKEN_AGE:
                case self::TOKEN_LEGAL_FORM:
                case self::TOKEN_BIRTH_COUNTY:
                    $this->registerFormattingFunction([$this, self::TOKEN_MAP[$token]]);
                    break;
                case self::TOKEN_ESCAPE:
                    $escape = $token;
                    break;
                default:
                    $escape = '';
                    $this->registerFormattingFunction(function () use ($token) {
                        return $token;
                    });
            }
        }
    }

    /**
     * Format id using registered formatting functions
     */
    public function format(IdInterface $idObject): string
    {
        return ($this->formatter)($idObject);
    }

    /**
     * Function must take an Id object and return a string
     */
    private function registerFormattingFunction($formatter): void
    {
        if (!is_callable($formatter)) {
            throw new LogicException('Formatting function must be callable');
        }

        $oldFormatter = $this->formatter;
        $this->formatter = function (IdInterface $idObject) use ($oldFormatter, $formatter) {
            return $oldFormatter($idObject) . $formatter($idObject);
        };
    }

    private function formatCentury(IdInterface $idObject): string
    {
        return $idObject->getCentury();
    }

    private function formatSerialPre(IdInterface $idObject): string
    {
        return $idObject->getSerialPreDelimiter();
    }

    private function formatSerialPost(IdInterface $idObject): string
    {
        return $idObject->getSerialPostDelimiter();
    }

    private function formatDelimiter(IdInterface $idObject): string
    {
        return $idObject->getDelimiter();
    }

    private function formatCheckDigit(IdInterface $idObject): string
    {
        return $idObject->getCheckDigit();
    }

    private function formatSex(IdInterface $idObject): string
    {
        return $idObject->getSex();
    }

    private function formatAge(IdInterface $idObject): string
    {
        return (string)$idObject->getAge();
    }

    private function formatLegalForm(IdInterface $idObject): string
    {
        return $idObject->getLegalForm();
    }

    private function formatBirthCounty(IdInterface $idObject): string
    {
        return $idObject->getBirthCounty();
    }
}
