<?php
namespace itbz\STB\Accounting;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class ChartOfAccountsTest extends \PHPUnit_Framework_TestCase
{

    function testAddAccount()
    {
        $p = new ChartOfAccounts();
        $p->addAccount(new Account('1920', 'T', 'Bank'));
        $this->assertTrue($p->accountExists('1920'));
    }


    function testRemoveAccount()
    {
        $p = new ChartOfAccounts();
        $p->addAccount(new Account('1920', 'T', 'Bank'));
        $this->assertTrue($p->accountExists('1920'));
        $p->removeAccount('1920');
        $this->assertFalse($p->accountExists('1920'));

        // Removing unexisting accounts do no harm
        $p->removeAccount('1920');
        $this->assertFalse($p->accountExists('1920'));
    }

    
    function testGetAccount()
    {
        $p = new ChartOfAccounts();
        $a = new Account('1920', 'T', 'Bank');
        $p->addAccount($a);
        $this->assertEquals($a, $p->getAccount('1920'));
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAccountException
     */
    function testGetInvalidAccount()
    {
        $p = new ChartOfAccounts();
        $p->getAccount('1920');
    }


    function testGetAccountFromName()
    {
        $p = new ChartOfAccounts();
        $a = new Account('1920', 'T', 'Bank');
        $p->addAccount($a);
        $this->assertEquals($a, $p->getAccountFromName('Bank'));
    }
    

    /**
     * @expectedException itbz\STB\Exception\InvalidAccountException
     */
    function testGetInvalidAccountFromName()
    {
        $p = new ChartOfAccounts();
        $p->getAccountFromName('Bank');
    }


    function testAlterAccount()
    {
        // There is no special alter method, add is used
        $p = new ChartOfAccounts();
        $a = new Account('1920', 'T', 'Bank');
        $p->addAccount($a);
        $this->assertEquals($a, $p->getAccount('1920'));

        $a = new Account('1920', 'T', 'Altered');
        $p->addAccount($a);
        $this->assertEquals($a, $p->getAccount('1920'));
    }

    function testGetChart()
    {
        $p = new ChartOfAccounts();
        $p->addAccount(new Account('1920', 'T', 'Bank'));
        $p->addAccount(new Account('1510', 'T', 'Fordringar'));
        $expected = array(
            1920 => new Account('1920', 'T', 'Bank'),
            1510 => new Account('1510', 'T', 'Fordringar')
        );
        $this->assertEquals($expected, $p->getAccounts());
    }


    function testSetGetChartType()
    {
        $p = new ChartOfAccounts();
        $this->assertEquals('EUBAS97', $p->getChartType());
        $p->setChartType('BAS96');
        $this->assertEquals('BAS96', $p->getChartType());
    }


    function testExportImport()
    {
        $p = new ChartOfAccounts();
        $p->addAccount(new Account('1920', 'T', 'Bank'));
        $p->addAccount(new Account('3000', 'I', 'Income'));

        $str = serialize($p);
        $p2 = unserialize($str);        

        $this->assertTrue($p->accountExists('1920'));
        $this->assertEquals(new Account('3000', 'I', 'Income'), $p->getAccount('3000'));
    }

}
