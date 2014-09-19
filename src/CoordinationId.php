<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Swedish coordination id number
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class CoordinationId extends PersonalId
{
    /**
     * Swedish coordination id number
     *
     * A coordination number is like a personal number except that 60 is added
     * to the date of birth.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        list(, $century, $datestr, $delim, $nr, $check) = CoordinationId::parseStructure($id);
        $dob = intval($datestr) - 60;
        return parent::__construct($century.$dob.$delim.$nr.$check);
    }

    /**
     * Get part of serial number after delimiter, 3 digits
     *
     * @return string
     */
    public function getSerialPreDelimiter()
    {
        return intval(parent::getSerialPreDelimiter()) + 60;
    }
}
