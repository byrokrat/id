<?php

namespace byrokrat\id\Component;

use byrokrat\id\Id;

/**
 * Helper that defines getSex(), isMale(), isFemale() and isSexUndefined().
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
