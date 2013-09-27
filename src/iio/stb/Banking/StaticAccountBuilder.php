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
     * @param  string          $number Clearing + , + account number
     * @return AbstractAccount
     * @throws Exception       If unable to create
     */
    public static function build($number)
    {
        self::init();
        self::$builder->setAccount($number);

        return self::$builder->getAccount();
    }
}
