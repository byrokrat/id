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
class BankAccountFactory
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
        'UnknownAccount'
    );

    /**
     * @var string The raw account number
     */
    private $rawNumber = '';

    /**
     * Enable account type
     *
     * @param  string             $classname
     * @return BankAccountFactory Returns instance to enable chaining
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
     * @param  string             $classname
     * @return BankAccountFactory Returns instance to enable chaining
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
     * @return BankAccountFactory Returns instance to enable chaining
     */
    public function clearClasses()
    {
        $this->classes = array();

        return $this;
    }

    /**
     * Set raw account number
     *
     * @param  string             $rawNumber Clearing + , + account number
     * @return BankAccountFactory Returns instance to enable chaining
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
     * @return BankAccountInterface
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
