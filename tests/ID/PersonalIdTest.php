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

class PersonalIdTest extends \PHPUnit_Framework_TestCase
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
            array('120101-A234'),
            array('120101-12345'),
            array('120101+A234'),
            array('120101+12345'),
            array('')
        );
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('820323-2770'),
            array('820323-2771'),
            array('820323-2772'),
            array('820323-2773'),
            array('820323-2774'),
            array('820323-2776'),
            array('820323-2777'),
            array('820323-2778'),
            array('820323-2779'),
            array('820323+2770'),
            array('820323+2771'),
            array('820323+2772'),
            array('820323+2773'),
            array('820323+2774'),
            array('820323+2776'),
            array('820323+2777'),
            array('820323+2778'),
            array('820323+2779'),
            array('123456-1234'),
            array('123456+1234'),
        );
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new PersonalId($nr);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($nr)
    {
        new PersonalId($nr);
    }

    public function testCentry()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('1982', $id->getDate()->format('Y'));

        $id = new PersonalId('820323+2775');
        $this->assertEquals('1882', $id->getDate()->format('Y'));

        $id = new PersonalId('450415-0220');
        $this->assertEquals('1945', $id->getDate()->format('Y'));
    }

    public function testDelimiter()
    {
        $id = new PersonalId('19820323+2775');
        $this->assertEquals('820323-2775', $id->getId());

        $id = new PersonalId('18820323-2775');
        $this->assertEquals('820323+2775', $id->getId());
    }

    public function testSex()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('M', $id->getSex());

        $id = new PersonalId('770314-0348');
        $this->assertEquals('F', $id->getSex());
    }

    public function testDOB()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('1982-03-23', $id->getDOB());

        $id = new PersonalId('19820323-2775');
        $this->assertEquals('1982-03-23', $id->getDOB());
    }

    public function testToString()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('820323-2775', (string)$id);
    }

    public function testGetLongId()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('19820323-2775', $id->getLongId());
    }
}
