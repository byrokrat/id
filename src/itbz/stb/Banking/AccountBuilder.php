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
 * @package STB\Banking
 */
namespace itbz\STB\Banking;
use itbz\STB\Exception;
use itbz\STB\Exception\InvalidClearingException;


/**
 * Build account from registered classes
 *
 * @package STB\Banking
 */
class AccountBuilder
{

    /**
     * List of possible account classes
     *
     * @var array
     */
    private $_classes = array(
        'NordeaPerson',
        'NordeaTyp1A',
        'NordeaTyp1B',
        'SwedbankTyp1',
        'SwedbankTyp2',
        'SEB'
    );


    /**
     * The raw account number
     *
     * @var string
     */
    private $_rawNumber = '';


    /**
     * Enable account type
     *
     * @param string $classname
     *
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function enable($classname)
    {
        assert('is_string($classname)');
        $this->disable($classname);
        $this->_classes[] = $classname;

        return $this;
    }


    /**
     * Disable account type
     *
     * @param string $classname
     *
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function disable($classname)
    {
        assert('is_string($classname)');
        $index = array_search($classname, $this->_classes);
        if ($index !== FALSE) {
            unset($this->_classes[$index]);
        }
        
        return $this;
    }


    /**
     * Disable all enabled account types
     *
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function clearClasses()
    {
        $this->_classes = array();

        return $this;
    }


    /**
     * Set raw account number
     *
     * @param string $rawNumber Account number, including clearing number
     * separated by a comma.
     *
     * @return AccountBuilder Returns instance to enable chaining
     */
    public function setAccount($rawNumber)
    {
        assert('is_string($rawNumber)');
        $this->_rawNumber = $rawNumber;
        
        return $this;
    }


    /**
     * Get account object
     *
     * @return AbstractAccount
     *
     * @throws Exception if unable to create
     */    
    public function getAccount()
    {
        foreach ($this->_classes as $class) {
            try {
                // Create and return account object
                $class = "\\itbz\\STB\\Banking\\$class";
                $account = new $class($this->_rawNumber);

                return $account;
            } catch (InvalidClearingException $e) {
                // Invalid clearing, try next class
                continue;
            }
        }

        // Unable to create class
        $msg = "Unable to create account for number '{$this->_rawNumber}'";
        throw new Exception($msg);
    }

}
