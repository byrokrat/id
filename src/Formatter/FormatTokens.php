<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Formatter;

/**
 * List of formatting tokens
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface FormatTokens
{
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
     * Day of the month, 2 digits with leading zeros
     */
    const TOKEN_DATE_DAY = 'd';

    /**
     * Century part of year, 2 digits
     */
    const TOKEN_DATE_CENTURY = 'C';

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
     * Escape the following character
     */
    const TOKEN_ESCAPE = '\\';
}
