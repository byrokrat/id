<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\Accounting;

use iio\stb\Exception\InvalidChartException;
use iio\stb\Exception\InvalidAccountException;

/**
 * Container class for charts of accounts.
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb
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
