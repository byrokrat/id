<?php
namespace itbz\STB\Accounting;
use itbz\STB\Utils\Amount;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class TransactionTest extends \PHPUnit_Framework_TestCase
{

    function testGetAccount()
    {
        $account = new Account('1920', 'T', 'PlusGiro');
        $amount = new Amount(100.101);
        $t = new Transaction($account, $amount);
        $this->assertEquals($account, $t->getAccount());
    }

    
    function testGetAmount()
    {
        $account = new Account('1920', 'T', 'PlusGiro');
        $amount = new Amount(100);
        $t = new Transaction($account, $amount);
        $a = $t->getAmount();
        $this->assertEquals($amount, $a);
    }

}
