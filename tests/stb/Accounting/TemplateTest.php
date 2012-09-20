<?php
namespace itbz\STB\Accounting;
use DateTime;
use itbz\STB\Utils\Amount;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class TemplateTest extends \PHPUnit_Framework_TestCase
{

    function getChart()
    {
        $c = new ChartOfAccounts();
        $c->addAccount(new Account('1920', 'T', 'Bank'));
        $c->addAccount(new Account('1510', 'T', 'Claims'));
        $c->addAccount(new Account('3000', 'I', 'Incomes'));
        $c->addAccount(new Account('3990', 'I', 'Benefits'));
        return $c;
    }


    function testGetSetId()
    {
        $t = new Template();
        $this->assertEquals('', $t->getId());
        $t->setId('foo');
        $this->assertEquals('foo', $t->getId());
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidTemplateException
     */
    function testSetIdError()
    {
        $t = new Template();
        $t->setId('1234567');
    }


    function testGetSetName()
    {
        $t = new Template();
        $this->assertEquals('', $t->getName());
        $t->setName('foo');
        $this->assertEquals('foo', $t->getName());
    }

    
    /**
     * @expectedException itbz\STB\Exception\InvalidTemplateException
     */
    function testSetNameError()
    {
        $t = new Template();
        $t->setName('123456789012345678901');
    }


    function testGetSetText()
    {
        $t = new Template();
        $this->assertEquals('', $t->getText());
        $t->setText('foo');
        $this->assertEquals('foo', $t->getText());
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidTemplateException
     */
    function testSetTextError()
    {
        $t = new Template();
        $t->setText('1234567890123456789012345678901234567890123456789012345678901');
    }


    function testVerTextAndAmountTranslation()
    {
        $t = new Template();
        $t->addTransaction('{in}', '-400');
        $t->addTransaction('1920', '{amount}');

        $t->substitute(array(
            'in' => '1920',
            'amount' => '400'
        ));
        
        $ver = $t->buildVerification($this->getChart());
        
        $expected = array(
            new Transaction(new Account('1920', 'T', 'Bank'), new Amount('-400')),
            new Transaction(new Account('1920', 'T', 'Bank'), new Amount('400')),
        );
        $this->assertEquals($expected, $ver->getTransactions());
     }


    function testTransactionTranslation()
    {
        $t = new Template();
        $t->setText('One {key} three');
        $t->substitute(array(
            'key' => 'two'
        ));
        $ver = $t->buildVerification($this->getChart());
        $this->assertEquals('One two three', $ver->getText());
    }



    function testAccountConversion()
    {
        $t = new Template();
        $t->addTransaction('1920', '450');
        $t->addTransaction('3000', '-450');

        $ver = $t->buildVerification($this->getChart());

        $expected = array(
            new Transaction(new Account('1920', 'T', 'Bank'), new Amount('450')),
            new Transaction(new Account('3000', 'I', 'Incomes'), new Amount('-450')),
        );
        $this->assertEquals($expected, $ver->getTransactions());
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     */
    function testMissingAmountKey()
    {
        $t = new Template();
        $t->addTransaction('3000', '-{value}');
        $ver = $t->buildVerification($this->getChart());
    }

}
