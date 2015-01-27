<?php

namespace byrokrat\id\Formatter;

/**
 * List of formatting tokens
 */
interface FormatTokens
{
    /**
     * Part of serial number before delimiter, 6 digits
     */
    const TOKEN_SERIAL_PRE = 'S';

    /**
     * Part of serial number after delimiter, 3 digits
     */
    const TOKEN_SERIAL_POST = 's';

    /**
     * Date and control string delimiter (- or +)
     */
    const TOKEN_DELIMITER = '-';

    /**
     * Check digit
     */
    const TOKEN_CHECK_DIGIT = 'k';

    /**
     * Sex, one character (F, M or O)
     */
    const TOKEN_SEX = 'X';

    /**
     * Current age
     */
    const TOKEN_AGE = 'A';

    /**
     * Legal form (empty if not applicable)
     */
    const TOKEN_LEGAL_FORM = 'L';

    /**
     * Birth county (empty if not applicable)
     */
    const TOKEN_BIRTH_COUNTY = 'B';

    /**
     * Escape the following character
     */
    const TOKEN_ESCAPE = '\\';

    /**
     * Century part of year, 2 digits
     */
    const TOKEN_DATE_CENTURY = 'C';

    /**
     * A full numeric representation of a year, 4 digits
     */
    const TOKEN_DATE_YEAR_FULL = 'Y';

    /**
     * A two digit representation of a year
     */
    const TOKEN_DATE_YEAR = 'y';

    /**
     * Numeric representation of a month, with leading zeros
     */
    const TOKEN_DATE_MONTH = 'm';

    /**
     * Numeric representation of a month, without leading zeros  1 through 12
     */
    const TOKEN_DATE_MONTH_SHORT = 'n';

    /**
     * A full textual representation of a month, such as January or March
     */
    const TOKEN_DATE_MONTH_TEXT = 'F';

    /**
     * A short textual representation of a month, three letters, Jan through Dec
     */
    const TOKEN_DATE_MONTH_TEXT_SHORT = 'M';

    /**
     * Number of days in the given month 28 through 31
     */
    const TOKEN_DATE_MONTH_DAYS = 't';

    /**
     * ISO-8601 week number of year, weeks starting on Monday Example: 42 (the 42nd week in the year)
     */
    const TOKEN_DATE_WEEK = 'W';

    /**
     * Day of the month, 2 digits with leading zeros
     */
    const TOKEN_DATE_DAY = 'd';

    /**
     * Day of the month without leading zeros, 1 to 31
     */
    const TOKEN_DATE_DAY_SHORT = 'j';

    /**
     * A full textual representation of the day of the week
     */
    const TOKEN_DATE_DAY_TEXT = 'l';

    /**
     * A textual representation of a day, three letters  Mon through Sun
     */
    const TOKEN_DATE_DAY_TEST_SHORT = 'D';

    /**
     * Numeric representation of the day of the week 0 (for Sunday) through 6 (for Saturday)
     */
    const TOKEN_DATE_DAY_NUMERIC = 'w';

    /**
     * ISO-8601 numeric representation of the day of the week 1 (for Monday) through 7 (for Sunday)
     */
    const TOKEN_DATE_DAY_NUMERIC_ISO = 'N';

    /**
     * The day of the year (starting from 0) 0 through 365
     */
    const TOKEN_DATE_DAY_OF_YEAR = 'z';
}
