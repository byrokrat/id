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

namespace iio\stb\Utils;

class Modulo11Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider testVerifyStructureProvider
     */
    public function testVerifyStructure($nr)
    {
        $m = new Modulo11();
        $m->verify($nr);
    }

    public function testVerifyStructureProvider()
    {
        return array(
            array('y'),
            array(''),
            array('1234x'),
            array('X2'),
            array(1234),
            array('1234.234'),
        );
    }

    public function testVerify()
    {
        $m = new Modulo11();

        // Valid check digits
        $this->assertTrue($m->verify('0365327'));
        $this->assertTrue($m->verify('3928444042'));
        $this->assertTrue($m->verify('0131391399'));
        $this->assertTrue($m->verify('007007013X'));
        $this->assertTrue($m->verify('013139139119'));
        $this->assertTrue($m->verify('0365300'));

        // Invalid ckeck digits
        $this->assertFalse($m->verify('0365321'));
        $this->assertFalse($m->verify('3928444041'));
        $this->assertFalse($m->verify('0131391391'));
        $this->assertFalse($m->verify('0070070131'));
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider testGetCheckDigitStructureProvider
     */
    public function testGetCheckDigitStructure($nr)
    {
        $m = new Modulo11();
        $m->getCheckDigit($nr);
    }

    public function testGetCheckDigitStructureProvider()
    {
        return array(
            array('y'),
            array(''),
            array('X2'),
            array(1234),
            array('123X'),
            array('1234.234'),
        );
    }

    public function testGetCheckDigit()
    {
        $m = new Modulo11();
        $this->assertEquals($m->getCheckDigit('036532'), '7');
        $this->assertEquals($m->getCheckDigit('392844404'), '2');
        $this->assertEquals($m->getCheckDigit('013139139'), '9');
        $this->assertEquals($m->getCheckDigit('01313913911'), '9');
        $this->assertEquals($m->getCheckDigit('007007013'), 'X');
        $this->assertEquals($m->getCheckDigit('036530'), '0');
    }
}
