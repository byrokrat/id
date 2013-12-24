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

use iio\stb\Exception\InvalidChartException;
use iio\stb\Exception\InvalidAccountException;

/**
 * Container class for charts of accounts.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class ChartOfAccounts
{
    /**
     * @var array Internal chart
     */
    private $accounts = array();

    /**
     * @var string Chart type
     */
    private $type = 'EUBAS97';

    /**
     * Add account
     *
     * @param  Account $account
     * @return void
     */
    public function addAccount(Account $account)
    {
        $nr = intval($account->getNumber());
        $this->accounts[$nr] = $account;
    }

    /**
     * Get account object for number
     *
     * @param  string                  $number
     * @return Account
     * @throws InvalidAccountException If account does not exist
     */
    public function getAccount($number)
    {
        if ($this->accountExists($number)) {
            return $this->accounts[$number];
        } else {
            $msg = "Account number '$number' does not exist";
            throw new InvalidAccountException($msg);
        }
    }

    /**
     * Get account object for name
     *
     * @param  string                  $name
     * @return Account
     * @throws InvalidAccountException If account does not exist
     */
    public function getAccountFromName($name)
    {
        foreach ($this->accounts as $account) {
            if ($account->getName() == $name) {
                return $account;
            }
        }
        $msg = "Account name '$name' does not exist";
        throw new InvalidAccountException($msg);
    }

    /**
     * Remove account
     *
     * @param  string $number
     * @return void
     */
    public function removeAccount($number)
    {
        unset($this->accounts[$number]);
    }

    /**
     * Validate that account exists in chart
     *
     * @param  string $number
     * @return bool
     */
    public function accountExists($number)
    {
        return isset($this->accounts[$number]);
    }

    /**
     * Get the complete chart of accounts
     *
     * @return array
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Set string describing type of chart used
     *
     * @param  string $type
     * @return void
     */
    public function setChartType($type)
    {
        $this->type = (string)$type;
    }

    /**
     * Get string describing the type of chart used
     *
     * @return string
     */
    public function getChartType()
    {
        return $this->type;
    }
}
