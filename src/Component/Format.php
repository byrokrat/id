<?php

namespace byrokrat\id\Component;

use byrokrat\id\Formatter\Formatter;

/**
 * Helper that defines format()
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
