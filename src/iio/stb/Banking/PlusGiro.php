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

use iio\stb\Utils\Modulo10;

/**
 * PlusGiro account
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class PlusGiro extends AbstractGiro
{
    /**
     * Get string describing account type
     *
     * @return string
     */
    public function getType()
    {
        return "PlusGiro";
    }

    /**
     * Get string describing account structure
     *
     * @return string
     */
    protected function getStructure()
    {
        return "/^\d{1,7}-\d$/";
    }
}
