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

class SwedbankTyp2Test extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('7999,1'),
            array('9000,1'),
        );
    }

    /**
     * @expectedException \iio\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new SwedbankTyp2($nr);
    }

    public function invalidStructuresProvider()
    {
        return array(
            array('8000,1'),
            array('8000,11111111111'),
            array('8000,0001111111111'),
        );
    }

    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($nr)
    {
        new SwedbankTyp2($nr);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('8000,1111112'),
            array('8214,9837107772'),
            array('8150,9942266951'),
            array('8327,9940298181'),
            array('8214,9846665701'),
            array('8214,9844447351'),
            array('8006,5330010161'),
            array('8424,39984101'),
            array('8150,9942187552'),
            array('8214,9133844001'),
        );
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($nr)
    {
        new SwedbankTyp2($nr);
    }

    public function validProvider()
    {
        return array(
            array('8000,1111111'),
            array('8000,000001111111'),
            array('8214,9837107771'),
            array('8150,9942266959'),
            array('8327,9940298186'),
            array('8214,9846665702'),
            array('8214,9844447350'),
            array('8006,5330010165'),
            array('8424,39984109'),
            array('8150,9942187551'),
            array('8214,9133844002'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new SwedbankTyp2($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new SwedbankTyp2('8000,001111111116');
        $this->assertEquals('8000,1111111116', (string)$m);

        $m = new SwedbankTyp2('8105,744202466');
        $this->assertEquals('8105,744202466', (string)$m);
    }

    public function testGetType()
    {
        $m = new SwedbankTyp2('8000,1111111');
        $this->assertEquals($m->getType(), 'Swedbank');
    }
}
