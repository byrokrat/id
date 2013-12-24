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

namespace iio\stb\ID;

class FakeIdTest extends \PHPUnit_Framework_TestCase
{
    public function invalidStructureProvider()
    {
        return array(
            array('123456'),
            array('123456-'),
            array('-1234'),
            array('123456-123'),
            array('123456-12345'),
            array('1234567-1234'),
            array('1234567-1234'),
            array('123456-1A34'),
            array('12A456-1234'),
            array('123456+'),
            array('+1234'),
            array('123456+123'),
            array('123456+12345'),
            array('1234567+1234'),
            array('1234567+1234'),
            array('123456+1A34'),
            array('12A456+1234'),

            array('123456-1234'),
            array('123456+1234'),
            array('820323-2775'),
            array('820323+2775'),
        );
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new FakeId($nr);
    }

    public function testCentry()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('1982', $id->getDate()->format('Y'));

        $id = new FakeId('820323+xxxx');
        $this->assertEquals('1882', $id->getDate()->format('Y'));

        $id = new FakeId('450415+xxxx');
        $this->assertEquals('1845', $id->getDate()->format('Y'));
    }

    public function testDelimiter()
    {
        $id = new FakeId('19820323+xx1x');
        $this->assertEquals('820323-xx1x', $id->getId());

        $id = new FakeId('18820323-xx2x');
        $this->assertEquals('820323+xx2x', $id->getId());
    }

    public function testSex()
    {
        $id = new FakeId('820323-xx1x');
        $this->assertEquals('M', $id->getSex());

        $id = new FakeId('770314-xx2x');
        $this->assertEquals('F', $id->getSex());

        $id = new FakeId('770314-xxxx');
        $this->assertEquals('O', $id->getSex());
    }

    public function testDOB()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('1982-03-23', $id->getDOB());
    }

    public function testToString()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('820323-xxxx', (string)$id);
    }
}
