<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

/**
 * Helper that defines getId() and __tostring()
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Stringify
{
    /**
     * Get id as string
     *
     * @return string
     */
    public function getId()
    {
        return $this->getSerialPreDelimiter()
            . $this->getDelimiter()
            . $this->getSerialPostDelimiter()
            . $this->getCheckDigit();
    }

    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->getId();
    }
}
