<?php
/**
 * This file is part of the STB package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 *
 * @package STB\Accounting
 */
namespace itbz\STB\Accounting;
use itbz\STB\Exception\InvalidChartException;
use itbz\STB\Exception\InvalidAccountException;


/**
 * Container class for charts of accounts.
 *
 * @package STB\Accounting
 */
class ChartOfAccounts
{

    /**
     * Internal chart
     *
     * @var array
     */
    private $_accounts = array();


    /**
     * Chart type
     *
     * @var string
     */
    private $_type = 'EUBAS97';


    /**
     * Add account
     *
     * @param Account $account
     *
     * @return void
     */
    public function addAccount(Account $account)
    {
        $nr = intval($account->getNumber());
        $this->_accounts[$nr] = $account;
    }


    /**
     * Get account object for number
     *
     * @param string $number
     *
     * @return Account
     *
     * @throws InvalidAccountException if account does not exist
     */
    public function getAccount($number)
    {
        if ( $this->accountExists($number) ) {
            return $this->_accounts[$number];
        } else {
            $msg = "Account number '$number' does not exist";
            throw new InvalidAccountException($msg);    
        }
    }


    /**
     * Get account object for name
     *
     * @param string $name
     *
     * @return Account
     *
     * @throws InvalidAccountException if account does not exist
     */
    public function getAccountFromName($name)
    {
        foreach ( $this->_accounts as $account ) {
            if ( $account->getName() == $name ) {
                return $account;
            }
        }
        $msg = "Account name '$name' does not exist";
        throw new InvalidAccountException($msg);    
    }


    /**
     * Remove account
     *
     * @param string $number
     *
     * @return void
     */
    public function removeAccount($number)
    {
        unset($this->_accounts[$number]);
    }


    /**
     * Validate that account exists in chart
     *
     * @param string $number
     *
     * @return bool
     */
    public function accountExists($number)
    {
        return isset($this->_accounts[$number]);
    }


    /**
     * Get the complete chart of accounts
     *
     * @return array
     */
    public function getAccounts()
    {
        return $this->_accounts;
    }


    /**
     * Set string describing type of chart used
     *
     * @param string $type
     *
     * @return void
     */
    public function setChartType($type)
    {
        $this->_type = (string)$type;
    }


    /**
     * Get string describing the type of chart used
     *
     * @return string
     */
    public function getChartType()
    {
        return $this->_type;
    }

}
