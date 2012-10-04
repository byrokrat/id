<?php
namespace itbz\STB\Accounting;


class AccountTest extends \PHPUnit_Framework_TestCase
{

    /**
     * List of invalid account values
     */
    function invalidAccountProvider()
    {
        return array(
            array('a', 'I', 'Name'),
            array('', 'I', 'Name'),
            array('123', 'I', 'Name'),
            array('12345', 'I', 'Name'),
            array('1234', 'A', 'Name'),
            array('1234', 'I', ''),
            array('1234', 'I', 123),
        );
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAccountException
     * @dataProvider invalidAccountProvider
     */
    function testAddAccountFaliure($account, $type, $name)
    {
        $a = new Account($account, $type, $name);
    }



    function testConstruct()
    {
        $a = new Account('1920', 'T', 'PlusGiro');
        $this->assertTrue(TRUE);
    }


    function testEquals()
    {
        $a = new Account('1920', 'T', 'PlusGiro');
        $a1 = new Account('1920', 'T', 'PlusGiro');
        $b = new Account('3000', 'T', 'PlusGiro');
        $c = new Account('1920', 'I', 'PlusGiro');
        $d = new Account('1920', 'T', 'Bank');
        $this->assertTrue($a->equals($a1));
        $this->assertFalse($a->equals($b));
        $this->assertFalse($a->equals($c));
        $this->assertFalse($a->equals($d));
    }

}
