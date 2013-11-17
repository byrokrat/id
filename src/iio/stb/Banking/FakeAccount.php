<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\Banking;

/**
 * Fake account, all is valid
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class FakeAccount extends AbstractAccount
{
    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "Unknown";
    }

    /**
     * Get string describing account structure
     *
     * @return string
     */
    protected function getStructure()
    {
        return "/.*/";
    }

    /**
     * Validate clearing number
     *
     * @return bool
     */
    protected function isValidClearing()
    {
        return true;
    }

    /**
     * Validate account number check digit
     *
     * @return bool
     */
    protected function isValidCheckDigit()
    {
        return true;
    }
}
