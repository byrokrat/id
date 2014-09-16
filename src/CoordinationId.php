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
        // Deduct 60 from dob before setting id
        $split = preg_split("/([-+])/", $id, 2, PREG_SPLIT_DELIM_CAPTURE);
        $id = intval(array_shift($split)) - 60;

        foreach ($split as $part) {
            $id .= $part;
        }

        return parent::__construct($id);
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return intval($this->getDate()->format('ymd')) + 60
            . $this->getDelimiter()
            . $this->getIndividualNr()
            . $this->getCheckDigit();
    }
}
