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

namespace iio\stb\Accounting;

use iio\stb\Exception\InvalidAccountException;

/**
 * Simple Account class
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Account
{
    /**
     * @var string Account number
     */
    private $number;

    /**
     * @var string Account type
     */
    private $type;

    /**
     * @var string Account name
     */
    private $name;

    /**
     * Constructor
     *
     * @param  string                  $number
     * @param  string                  $type   Account type (T, S, I or K)
     * @param  string                  $name
     * @throws InvalidAccountException If any data is invalid
     */
    public function __construct($number, $type, $name)
    {
        $number = intval($number);
        if ($number < 1000 || $number > 9999) {
            $msg = "Account must be numeric, 999 < number < 10000";
            throw new InvalidAccountException($msg);
        }

        $this->number = (string)$number;

        if (!in_array($type, array('T', 'S', 'I', 'K'))) {
            $msg = "Account type must be T, S, I or K";
            throw new InvalidAccountException($msg);
        }

        $this->type = $type;

        if (!is_string($name) || empty($name)) {
            $msg = "Account name can not be empty";
            throw new InvalidAccountException($msg);
        }

        $this->name = $name;
    }

    /**
     * Get account number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get account type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get account name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Validate that $account equals this instance
     *
     * @param  Account $account
     * @return bool
     */
    public function equals(Account $account)
    {
        if ($this->getNumber() != $account->getNumber()
            || $this->getType() != $account->getType()
            || $this->getName() != $account->getName()
        ) {
            return false;
        }
        return true;
    }
}
