<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Banking;

use iio\stb\Exception;
use iio\stb\Exception\InvalidClearingException;

/**
 * Build account from registered classes
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class StaticAccountBuilder
{
    /**
     * @var AccountBuilder Regular AccountBuilder instance
     */
    private static $builder;

    /**
     * Create internal AccountBuilder instance
     *
     * @return void
     */
    private static function init()
    {
        if (!isset(self::$builder)) {
            self::$builder = new AccountBuilder();
        }
    }

    /**
     * Enable account type
     *
     * @param  string $classname
     * @return void
     */
    public static function enable($classname)
    {
        self::init();
        self::$builder->enable($classname);
    }

    /**
     * Disable account type
     *
     * @param  string $classname
     * @return void
     */
    public static function disable($classname)
    {
        self::init();
        self::$builder->disable($classname);
    }

    /**
     * Disable all enabled account types
     *
     * @return void
     */
    public static function clearClasses()
    {
        self::init();
        self::$builder->clearClasses();
    }

    /**
     * Get account object
     *
     * @param  string           $number Clearing + , + account number
     * @return AccountInterface
     * @throws Exception        If unable to create
     */
    public static function build($number)
    {
        self::init();
        self::$builder->setAccount($number);

        return self::$builder->getAccount();
    }
}
