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
 * Coordination id number
 *
 * A coordination number is like a personal number except that 60 is added
 * to the date of birth.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class CoordinationId extends PersonalId
{
    use Component\BirthCounty;

    /**
     * {@inheritdoc}
     *
     * @param string $number
     */
    public function __construct($number)
    {
        list(, $century, $datestr, $delim, $serialPost, $check) = CoordinationId::parseStructure($number);
        $dob = intval($datestr) - 60;
        return parent::__construct($century.$dob.$delim.$serialPost.$check);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getSerialPreDelimiter()
    {
        return (string) intval(parent::getSerialPreDelimiter()) + 60;
    }
}
