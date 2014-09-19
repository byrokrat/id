<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\id\Formatter;

/**
 * Helper that defines format()
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Format
{
    /**
     * Format id according to format string
     *
     * @param  string $format
     * @return string
     */
    public function format($format)
    {
        return (new Formatter($format))->format($this);
    }
}
