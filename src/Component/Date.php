<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\id\DateTime;
use ledgr\id\Exception\DateNotSupportedException;

/**
 * Helper that defines getDate() and getAge()
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Date
{
    /**
     * As default date is N/A
     *
     * @return DateTime
     * @throws DateNotSupportedException If date is not set
     */
    public function getDate()
    {
        throw new DateNotSupportedException("Trying to access date on id type where it is not supported");
    }

    /**
     * Get current age
     *
     * @return int
     */
    public function getAge()
    {
        return (int)$this->getDate()->diff(new DateTime)->format('%y');
    }

    /**
     * Get century part of date, 2 digits
     *
     * @return string
     */
    public function getCentury()
    {
        return substr($this->getDate()->format('Y'), 0, 2);
    }
}
