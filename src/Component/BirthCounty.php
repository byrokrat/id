<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\id\Id;

/**
 * Default implementation of getBirthCounty()
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
