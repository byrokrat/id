<?php

namespace byrokrat\id\Component;

use byrokrat\id\IdInterface;

/**
 * Default implementation of getBirthCounty()
 */
trait BirthCounty
{
    /**
     * Get string describing birth county
     *
     * @return string One of the birth county identifier constants
     */
    public function getBirthCounty()
    {
        return IdInterface::COUNTY_UNDEFINED;
    }
}
