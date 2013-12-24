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

use DateTime;
use iio\stb\Utils\Amount;

class VerificationTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetText()
    {
        $v = new Verification();
        $v->setText('test');
        $this->assertEquals($v->getText(), 'test');
    }

    public function testSetGetDate()
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

    public function testGetTransactions()
    {
        $bank = new Account('1920', 'T', 'Bank');
        $income = new Account('3000', 'I', 'Income');
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }
        $this->assertEquals($trans, $v->getTransactions());
    }

    public function testGetAccounts()
    {
        $bank = new Account('1920', 'T', 'Bank');
        $income = new Account('3000', 'I', 'Income');

        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-300')),
        );

        $v = new Verification('test');
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }

        $a = $v->getAccounts();

        $this->assertEquals(2, count($a));
        $this->assertTrue(isset($a[1920]));
        $this->assertTrue(isset($a[3000]));
    }

    public function testIsBalanced()
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
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }
        $this->assertTrue($v->isBalanced());

        // A unbalanced verification
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }
        $this->assertFalse($v->isBalanced());
    }

    public function testGetDifference()
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
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }
        $this->assertEquals((string)new Amount('0'), (string)$v->getDifference());

        // A negaitve verification
        $trans = array(
            new Transaction($bank, new Amount('100')),
            new Transaction($income, new Amount('-300')),
        );
        $v = new Verification('test');
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }
        $this->assertEquals((string)new Amount('-200'), (string)$v->getDifference());

        // A positive verification
        $trans = array(
            new Transaction($bank, new Amount('200')),
            new Transaction($income, new Amount('-100')),
        );
        $v = new Verification('test');
        foreach ($trans as $t) {
            $v->addTransaction($t);
        }
        $this->assertEquals((string)new Amount('100'), (string)$v->getDifference());
    }
}
