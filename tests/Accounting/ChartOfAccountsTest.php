<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Accounting;

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
     * @expectedException iio\stb\Exception\InvalidAccountException
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
     * @expectedException iio\stb\Exception\InvalidAccountException
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
