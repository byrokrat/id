<?php

namespace byrokrat\id\Formatter;

use byrokrat\id\IdInterface;

/**
 * Id formatter
 */
class Formatter implements FormatTokens
{
    use FormattingFunctions;

    /**
     * @var \Closure Formatting function, takes an Id object and returns a string
     */
    private $formatter;

    /**
     * Create formatter from format string
     *
     * @param string $format
     */
    public function __construct($format = '')
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
                    $this->registerFormatter(function (IdInterface $idObjectObject) use ($token) {
                        return $idObjectObject->getDate()->format($token);
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
                    $this->registerFormatter([$this, self::$tokenMap[$token]]);
                    break;
                case self::TOKEN_ESCAPE:
                    $escape = $token;
                    break;
                default:
                    $escape = '';
                    $this->registerFormatter(function () use ($token) {
                        return $token;
                    });
            }
        }
    }

    /**
     * Register formatting function
     *
     * Registered function must take an Id object and return a string
     *
     * @param  callable $formatter Formatting function
     * @return void
     */
    public function registerFormatter(callable $formatter)
    {
        $oldFormatter = $this->formatter;
        $this->formatter = function (IdInterface $idObject) use ($oldFormatter, $formatter) {
            return $oldFormatter($idObject) . $formatter($idObject);
        };
    }

    /**
     * Format id using registered formatting functions
     *
     * @param  IdInterface $idObject
     * @return string
     */
    public function format(IdInterface $idObject)
    {
        $formatter = $this->formatter;
        return $formatter($idObject);
    }
}
