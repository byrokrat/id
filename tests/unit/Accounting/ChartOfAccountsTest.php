<?php
namespace itbz\STB\Accounting;

class ChartOfAccountsTest extends \PHPUnit_Framework_TestCase
{
    public function testAddAccount()
    {
        $p = new ChartOfAccounts();
        $p->addAccount(new Account('1920', 'T', 'Bank'));
        $this->assertTrue($p->accountExists('1920'));
    }

    public function testRemoveAccount()
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

    public function testGetAccount()
    {
        $p = new ChartOfAccounts();
        $a = new Account('1920', 'T', 'Bank');
        $p->addAccount($a);
        $this->assertEquals($a, $p->getAccount('1920'));
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidAccountException
     */
    public function testGetInvalidAccount()
    {
        $p = new ChartOfAccounts();
        $p->getAccount('1920');
    }

    public function testGetAccountFromName()
    {
        $p = new ChartOfAccounts();
        $a = new Account('1920', 'T', 'Bank');
        $p->addAccount($a);
        $this->assertEquals($a, $p->getAccountFromName('Bank'));
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidAccountException
     */
    public function testGetInvalidAccountFromName()
    {
        $p = new ChartOfAccounts();
        $p->getAccountFromName('Bank');
    }

    public function testAlterAccount()
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

    public function testGetChart()
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

    public function testSetGetChartType()
    {
        $p = new ChartOfAccounts();
        $this->assertEquals('EUBAS97', $p->getChartType());
        $p->setChartType('BAS96');
        $this->assertEquals('BAS96', $p->getChartType());
    }

    public function testExportImport()
    {
        $p = new ChartOfAccounts();
        $p->addAccount(new Account('1920', 'T', 'Bank'));
        $p->addAccount(new Account('3000', 'I', 'Income'));

        $str = serialize($p);
        $p2 = unserialize($str);

        $this->assertTrue($p2->accountExists('1920'));
        $this->assertEquals(new Account('3000', 'I', 'Income'), $p2->getAccount('3000'));
    }
}
