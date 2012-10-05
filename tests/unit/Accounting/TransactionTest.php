<?php
namespace itbz\stb\Accounting;

use itbz\stb\Utils\Amount;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccount()
    {
        $account = new Account('1920', 'T', 'PlusGiro');
        $amount = new Amount(100.101);
        $t = new Transaction($account, $amount);
        $this->assertEquals($account, $t->getAccount());
    }

    public function testGetAmount()
    {
        $account = new Account('1920', 'T', 'PlusGiro');
        $amount = new Amount(100);
        $t = new Transaction($account, $amount);
        $a = $t->getAmount();
        $this->assertEquals($amount, $a);
    }
}
