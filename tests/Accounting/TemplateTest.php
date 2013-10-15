<?php
namespace iio\stb\Accounting;

use DateTime;
use iio\stb\Utils\Amount;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    public function getChart()
    {
        $c = new ChartOfAccounts();
        $c->addAccount(new Account('1920', 'T', 'Bank'));
        $c->addAccount(new Account('1510', 'T', 'Claims'));
        $c->addAccount(new Account('3000', 'I', 'Incomes'));
        $c->addAccount(new Account('3990', 'I', 'Benefits'));
        return $c;
    }

    public function testGetSetId()
    {
        $t = new Template();
        $this->assertEquals('', $t->getId());
        $t->setId('foo');
        $this->assertEquals('foo', $t->getId());
    }

    /**
     * @expectedException iio\stb\Exception\InvalidTemplateException
     */
    public function testSetIdError()
    {
        $t = new Template();
        $t->setId('1234567');
    }

    public function testGetSetName()
    {
        $t = new Template();
        $this->assertEquals('', $t->getName());
        $t->setName('foo');
        $this->assertEquals('foo', $t->getName());
    }

    /**
     * @expectedException iio\stb\Exception\InvalidTemplateException
     */
    public function testSetNameError()
    {
        $t = new Template();
        $t->setName('123456789012345678901');
    }

    public function testGetSetText()
    {
        $t = new Template();
        $this->assertEquals('', $t->getText());
        $t->setText('foo');
        $this->assertEquals('foo', $t->getText());
    }

    /**
     * @expectedException iio\stb\Exception\InvalidTemplateException
     */
    public function testSetTextError()
    {
        $t = new Template();
        $t->setText('1234567890123456789012345678901234567890123456789012345678901');
    }

    public function testVerTextAndAmountTranslation()
    {
        $t = new Template();
        $t->addTransaction('{in}', '-400');
        $t->addTransaction('1920', '{amount}');

        $t->substitute(
            array(
                'in' => '1920',
                'amount' => '400'
            )
        );

        $ver = $t->buildVerification($this->getChart());

        $expected = array(
            new Transaction(new Account('1920', 'T', 'Bank'), new Amount('-400')),
            new Transaction(new Account('1920', 'T', 'Bank'), new Amount('400')),
        );
        $this->assertEquals($expected, $ver->getTransactions());
    }

    public function testTransactionTranslation()
    {
        $t = new Template();
        $t->setText('One {key} three');
        $t->substitute(
            array(
                'key' => 'two'
            )
        );
        $ver = $t->buildVerification($this->getChart());
        $this->assertEquals('One two three', $ver->getText());
    }

    public function testAccountConversion()
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
     * @expectedException iio\stb\Exception\InvalidStructureException
     */
    public function testMissingAmountKey()
    {
        $t = new Template();
        $t->addTransaction('3000', '-{value}');
        $t->buildVerification($this->getChart());
    }
}
