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
 * Helper that defines getSex(), isMale(), isFemale() and isSexUndefined().
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait SexualIdentity
{
    /**
     * By default sex is undefined
     *
     * @return string Id::SEX_UNDEFINED
     */
    public function getSex()
    {
        return Id::SEX_UNDEFINED;
    }

    /**
     * Check if id represents a male
     *
     * @return boolean
     */
    public function isMale()
    {
        return $this->getSex() == Id::SEX_MALE;
    }

    /**
     * Check if id represents a female
     *
     * @return boolean
     */
    public function isFemale()
    {
        return $this->getSex() == Id::SEX_FEMALE;
    }

    /**
     * Check if sex not applicable
     *
     * @return boolean
     */
    public function isSexUndefined()
    {
        return $this->getSex() == Id::SEX_UNDEFINED;
    }
}
