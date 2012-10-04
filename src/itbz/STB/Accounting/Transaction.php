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
 * @package STB\Accounting
 */

namespace itbz\STB\Accounting;

use itbz\STB\Utils\Amount;

/**
 * Simple accounting transaction class
 *
 * @package STB\Accounting
 */
class Transaction
{
    /**
     * Account object
     *
     * @var Account
     */
    private $account;

    /**
     * Amount object
     *
     * @var Amount
     */
    private $amount;

    /**
     * Set account and amount.
     *
     * @param Account $account
     * @param Amount $amount
     */
    public function __construct(Account $account, Amount $amount)
    {
        $this->account = $account;
        $this->amount = $amount;
    }

    /**
     * Get account
     *
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Get amount
     *
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
