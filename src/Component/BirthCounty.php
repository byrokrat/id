<?php

namespace byrokrat\id\Component;

use byrokrat\id\Id;

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
        return Id::COUNTY_UNDEFINED;
    }
}
