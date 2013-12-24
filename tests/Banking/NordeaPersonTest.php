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

class NordeaPersonTest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('3299,1'),
            array('3301,1'),
            array('3781,1'),
            array('3783,1'),
        );
    }

    /**
     * @expectedException \iio\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new NordeaPerson($nr);
    }

    public function invalidStructuresProvider()
    {
        return array(
            array('3300,111111111'),
            array('3300,11111111111'),
            array('3300,0001111111111'),
        );
    }

    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($nr)
    {
        new NordeaPerson($nr);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('3300,1111111111'),
            array('3300,6707144311'),
            array('3300,8010153901'),
            array('3300,8201180241'),
            array('3300,8210057541'),
            array('3300,8502031901'),
            array('3300,8209307201'),
            array('3300,8609177621'),
            array('3300,5008302221'),
            array('3300,8411283942'),
        );
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($nr)
    {
        new NordeaPerson($nr);
    }

    public function validProvider()
    {
        return array(
            array('3300,1111111116'),
            array('3300,001111111116'),
            array('3300,6707144314'),
            array('3300,8010153909'),
            array('3300,8201180240'),
            array('3300,8210057546'),
            array('3300,8502031902'),
            array('3300,8209307209'),
            array('3300,8609177624'),
            array('3300,5008302225'),
            array('3300,8411283941'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new NordeaPerson($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new NordeaPerson('3300,001111111116');
        $this->assertEquals((string)$m, '3300,1111111116');
    }

    public function testTo16()
    {
        $m = new NordeaPerson('3300,1111111116');
        $this->assertEquals($m->to16(), '3300001111111116');
    }

    public function testGetType()
    {
        $m = new NordeaPerson('3300,1111111116');
        $this->assertEquals($m->getType(), 'Nordea');
    }
}
