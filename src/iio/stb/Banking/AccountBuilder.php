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
class AccountBuilder
{
    /**
     * @var array List of possible account classes
     */
    private $classes = array(
        'NordeaPerson',
        'NordeaTyp1A',
        'NordeaTyp1B',
        'SwedbankTyp1',
        'SwedbankTyp2',
        'SEB',
        'FakeAccount'
    );

    /**
     * @var string The raw account number
     */
    private $rawNumber = '';

    /**
     * Enable account type
     *
     * @param  string         $classname
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function enable($classname)
    {
        assert('is_string($classname)');
        $this->disable($classname);
        $this->classes[] = $classname;

        return $this;
    }

    /**
     * Disable account type
     *
     * @param  string         $classname
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function disable($classname)
    {
        assert('is_string($classname)');
        $index = array_search($classname, $this->classes);
        if ($index !== false) {
            unset($this->classes[$index]);
        }

        return $this;
    }

    /**
     * Disable all enabled account types
     *
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function clearClasses()
    {
        $this->classes = array();

        return $this;
    }

    /**
     * Set raw account number
     *
     * @param  string         $rawNumber Clearing + , + account number
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function setAccount($rawNumber)
    {
        assert('is_string($rawNumber)');
        $this->rawNumber = $rawNumber;

        return $this;
    }

    /**
     * Get account object
     *
     * @return AccountInterface
     * @throws Exception        If unable to create
     */
    public function getAccount()
    {
        foreach ($this->classes as $class) {
            try {
                // Create and return account object
                $class = "\\iio\\stb\\Banking\\$class";
                $account = new $class($this->rawNumber);

                return $account;
            } catch (InvalidClearingException $e) {
                // Invalid clearing, try next class
                continue;
            }
        }

        // Unable to create class
        throw new Exception("Unable to create account for number '{$this->rawNumber}'");
    }
}
