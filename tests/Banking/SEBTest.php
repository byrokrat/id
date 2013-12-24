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

namespace iio\stb\Banking;

class SEBTest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('4999,1'),
            array('6000,1'),
            array('9119,1'),
            array('9125,1'),
            array('9129,1'),
            array('9150,1'),
        );
    }

    /**
     * @expectedException \iio\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new SEB($nr);
    }

    public function invalidStructuresProvider()
    {
        return array(
            array('5000,111111'),
            array('5000,11111'),
            array('5000,11111111'),
            array('5000,0000001111111'),
        );
    }

    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($nr)
    {
        new SEB($nr);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('5000,1111111'),
            array('5681,0047150'),
            array('5102,0158750'),
            array('5624,0179270'),
            array('5011,0137390'),
            array('5169,0027450'),
            array('5007,0042700'),
            array('5502,0038521'),
            array('5504,0017150'),
            array('5624,0017790'),
        );
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($nr)
    {
        new SEB($nr);
    }

    public function validProvider()
    {
        return array(
            array('5000,1111116'),
            array('5000,000001111116'),
            array('5681,0047158'),
            array('5102,0158751'),
            array('5624,0179272'),
            array('5011,0137396'),
            array('5169,0027452'),
            array('5007,0042705'),
            array('5502,0038520'),
            array('5504,0017154'),
            array('5624,0017795'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new SEB($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new SEB('5000,000001111116');
        $this->assertEquals((string)$m, '5000,1111116');
    }

    public function testTo16()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->to16(), '5000000001111116');
    }

    public function testGetClearing()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getClearing(), '5000');
    }

    public function testGetNumber()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getNumber(), '1111116');
        $m = new SEB('5000,001111116');
        $this->assertEquals($m->getNumber(), '001111116');
    }

    public function testGetType()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getType(), 'SEB');
    }
}
