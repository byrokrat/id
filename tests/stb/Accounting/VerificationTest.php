<?php
namespace itbz\STB\Accounting;
use DateTime;
use itbz\STB\Utils\Amount;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class VerificationTest extends \PHPUnit_Framework_TestCase
{

    function testSetGetText()
    {
        $v = new Verification();
        $v->setText('test');
        $this->assertEquals($v->getText(), 'test');
    }


    function testSetGetDate()
    {
        $v = new Verification('test');
        $now = new DateTime();
        $this->assertTrue($v->getDate() <= $now);

        $v = new Verification('test', $now);
        $this->assertTrue($v->getDate() == $now);

        $v = new Verification('test');
        $v->setDate($now);
        $this->assertTrue($v->getDate() == $now);
    }


    function testGetTransactions()
    {
        $bank = new Account('1920', 'T', 'Bank');
        $income = new Account('3000', 'I', 'Income');
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);
        $this->assertEquals($trans, $v->getTransactions());
    }


    function testGetAccounts()
    {
        $bank = new Account('1920', 'T', 'Bank');
        $income = new Account('3000', 'I', 'Income');
        
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-300')),
        );

        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);

        $a = $v->getAccounts();

        $this->assertEquals(2, count($a));
        $this->assertTrue(isset($a[1920]));
        $this->assertTrue(isset($a[3000]));
    }


    function testIsBalanced()
    {
        $bank = new Account('1920', 'T', 'Bank');
        $income = new Account('3000', 'I', 'Income');

        //A balanced verification
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);
        $this->assertTrue($v->isBalanced());

        // A unbalanced verification
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);
        $this->assertFalse($v->isBalanced());
    }


    function testGetDifference()
    {
        $bank = new Account('1920', 'T', 'Bank');
        $income = new Account('3000', 'I', 'Income');

        //A balanced verification
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);
        $this->assertEquals(new Amount('0'), $v->getDifference());

        // A negaitve verification
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);
        $this->assertEquals(new Amount('-200'), $v->getDifference());

        // A positive verification
        $trans = array(
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-100')),
        );
        $v = new Verification('test');
        foreach ( $trans as $t ) $v->addTransaction($t);
        $this->assertEquals(new Amount('100'), $v->getDifference());
    }

}
