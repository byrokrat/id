<?php

namespace byrokrat\id\Component;

use byrokrat\id\Exception\DateNotSupportedException;

/**
 * Helper that defines getDate() and getAge()
 */
trait Date
{
    /**
     * As default date is N/A
     *
     * @return \DateTime
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
        return (int)$this->getDate()->diff(new \DateTime)->format('%y');
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
