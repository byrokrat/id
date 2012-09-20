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
use itbz\STB\Exception\InvalidAccountException;


/**
 * Simple Account class
 *
 * @package STB\Accounting
 */
class Account
{

    /**
     * Account number
     *
     * @var string
     */
    private $_number;
    
    
    /**
     * Account type
     *
     * @var string
     */
    private $_type;


    /**
     * Account name
     *
     * @var string
     */    
    private $_name;
    
    
    /**
     * Set account number, type and name
     *
     * @param string $number
     *
     * @param string $type Account type (T, S, I or K)
     *
     * @param string $name
     *
     * @throws InvalidAccountException if any data is invalid
     */
    public function __construct($number, $type, $name)
    {
        $number = intval($number);
        if ( $number < 1000 || $number > 9999 ) {
            $msg = "Account must be numeric, 999 < number < 10000";
            throw new InvalidAccountException($msg);
        }
        
        $this->_number = (string)$number;

        if ( !in_array($type, array('T', 'S', 'I', 'K')) ) {
            $msg = "Account type must be T, S, I or K";
            throw new InvalidAccountException($msg);
        }

        $this->_type = $type;

        if ( !is_string($name) || empty($name) ) {
            $msg = "Account name can not be empty";
            throw new InvalidAccountException($msg);
        }
        
        $this->_name = $name;
    }


    /**
     * Get account number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->_number;
    }


    /**
     * Get account type
     *
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }


    /**
     * Get account name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }


    /**
     * Validate that $account equals this instance
     *
     * @param Account $account
     *
     * @return bool
     */
    public function equals(Account $account)
    {
        if (
            ($this->getNumber() != $account->getNumber())
            || ($this->getType() != $account->getType())
            || ($this->getName() != $account->getName())
        ) {
            return FALSE;
        }
        return TRUE;
    }

}
