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

use iio\stb\Utils\Amount;

/**
 * Simple accounting transaction class
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Transaction
{
    /**
     * @var Account Account object
     */
    private $account;

    /**
     * @var Amount Amount object
     */
    private $amount;

    /**
     * Constructor
     *
     * @param Account $account
     * @param Amount  $amount
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
