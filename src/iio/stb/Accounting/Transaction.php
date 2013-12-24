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
