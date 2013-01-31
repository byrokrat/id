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

use DateTime;
use iio\stb\Utils\Amount;

/**
 * Simple accounting verification class
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb
 */
class Verification
{
    /**
     * @var string Text describing verification
     */
    private $text;

    /**
     * @var DateTime Verification date
     */
    private $date;

    /**
     * @var array List of transactions associated with this verification
     */
    private $transactions = array();

    /**
     * Constructor
     *
     * @param string   $text Text describing verification
     * @param DateTime $date
     */
    public function __construct($text = '', DateTime $date = null)
    {
        assert('is_string($text)');
        if (!$date) {
            $date = new DateTime();
        }
        $this->text = $text;
        $this->date = $date;
    }

    /**
     * Add new transaction
     *
     * @param  Transaction  $trans
     * @return Verification Instance for chaining
     */
    public function addTransaction(Transaction $trans)
    {
        $this->transactions[] = $trans;

        return $this;
    }

    /**
     * Get array of unique account numbers used in this verification
     *
     * @return array
     */
    public function getAccounts()
    {
        $accounts = array();
        foreach ($this->getTransactions() as $trans) {
            $account = $trans->getAccount();
            $accounts[$account->getNumber()] = $account;
        }

        return $accounts;
    }

    /**
     * Validate that this verification is balanced
     *
     * @return bool
     */
    public function isBalanced()
    {
        return $this->getDifference()->equals(new Amount('0'));
    }

    /**
     * Get transaction difference. 0 if verification is balanced
     *
     * @return Amount
     */
    public function getDifference()
    {
        $diff = new Amount('0');
        foreach ($this->getTransactions() as $trans) {
            $diff->add($trans->getAmount());
        }

        return $diff;
    }

    /**
     * Get text describing verification
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text describing verification
     *
     * @param  string       $text
     * @return Verification Instance for chaining
     */
    public function setText($text)
    {
        assert('is_string($text)');
        $this->text = $text;

        return $this;
    }

    /**
     * Get transaction date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set transaction date
     *
     * @param  DateTime     $date
     * @return Verification Instance for chaining
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get list of transactions
     *
     * @return array
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}
