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

use iio\stb\Exception\InvalidAccountException;

/**
 * Simple Account class
 *
 * @author  Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb
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
