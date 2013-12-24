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

class Modulo10Test extends \PHPUnit_Framework_TestCase
{
    public function invalidStructureProvider()
    {
        return array(
            array('y'),
            array(''),
            array(1234),
            array('12.12'),
        );
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testGetCheckDigitStructure($nr)
    {
        $m = new Modulo10();
        $m->getCheckDigit($nr);
    }

    public function testGetCheckDigit()
    {
        $m = new Modulo10();
        $this->assertEquals($m->getCheckDigit('5555555'), '1');
        $this->assertEquals($m->getCheckDigit('991234'), '6');
        $this->assertEquals($m->getCheckDigit('987654321'), '7');
        $this->assertEquals($m->getCheckDigit('4992739871'), '6');
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testVerifyStructure($nr)
    {
        $m = new Modulo10();
        $m->verify($nr);
    }

    public function testVerify()
    {
        $m = new Modulo10();

        // Valid check digits
        $this->assertTrue($m->verify('55555551'));
        $this->assertTrue($m->verify('9912346'));
        $this->assertTrue($m->verify('9876543217'));
        $this->assertTrue($m->verify('49927398716'));

        // Invalid ckeck digits
        $this->assertFalse($m->verify('55555550'));
        $this->assertFalse($m->verify('9912340'));
        $this->assertFalse($m->verify('9876543210'));
        $this->assertFalse($m->verify('49927398710'));
    }
}
