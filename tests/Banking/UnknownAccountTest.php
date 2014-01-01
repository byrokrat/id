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

class UnknownAccountTest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('915,1'),
            array('91115,1'),
        );
    }

    /**
     * @expectedException \iio\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new UnknownAccount($nr);
    }

    public function validProvider()
    {
        return array(
            array('5000,1111116'),
            array('5000,000001111116'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new UnknownAccount($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new UnknownAccount('5000,000001111116');
        $this->assertEquals((string)$m, '5000,000001111116');
    }

    public function testTo16()
    {
        $m = new UnknownAccount('5000,1111116');
        $this->assertEquals($m->to16(), '5000000001111116');
    }

    public function testGetType()
    {
        $m = new UnknownAccount('5000,1111116');
        $this->assertEquals($m->getType(), 'Unknown');
    }
}
