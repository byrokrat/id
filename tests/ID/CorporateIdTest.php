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

class CorporateIdTest extends \PHPUnit_Framework_TestCase
{
    public function invalidStructureProvider()
    {
        return array(
            array('123456'),
            array('123456+1234'),
            array('123456-123'),
            array('123456-12345'),
            array('12345-1234'),
            array('1234567-1234'),
            array('A23456-1234'),
            array('123456-A234'),
            array('111111-1234'),
            array('')
        );
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('502017-7750'),
            array('556097-8600'),
            array('556086-8220'),
            array('556432-4320'),
            array('556619-3050'),
            array('556337-2190'),
            array('556601-6900'),
            array('556758-1780'),
            array('232100-0010'),
            array('202100-5480'),
            array('835000-0890'),
            array('702001-7780'),
        );
    }

    public function validProvider()
    {
        return array(
            array('502017-7753'),
            array('556097-8602'),
            array('556086-8225'),
            array('556432-4324'),
            array('556619-3057'),
            array('556337-2191'),
            array('556601-6902'),
            array('556758-1789'),
            array('232100-0016'),
            array('202100-5489'),
            array('835000-0892'),
            array('702001-7781'),
        );
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new CorporateId($nr);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($nr)
    {
        new CorporateId($nr);
    }

    /**
     * @dataProvider validProvider
     */
    public function testValidIds($id)
    {
        $id = new CorporateId($id);
        $this->assertTrue(true);
    }

    public function testGetId()
    {
        $id = new CorporateId('702001-7781');
        $this->assertEquals($id->getId(), '702001-7781');
    }

    public function testToString()
    {
        $id = new CorporateId('702001-7781');
        $this->assertEquals((string)$id, '702001-7781');
    }

    public function testGetGroupDescription()
    {
        $id = new CorporateId('232100-0016');
        $this->assertEquals('Stat, landsting, kommun eller församling', $id->getGroupDescription());

        $id = new CorporateId('502017-7753');
        $this->assertEquals('Aktiebolag', $id->getGroupDescription());

        $id = new CorporateId('662011-0541');
        $this->assertEquals('Enkelt bolag', $id->getGroupDescription());

        $id = new CorporateId('702001-7781');
        $this->assertEquals('Ekonomisk förening', $id->getGroupDescription());

        $id = new CorporateId('835000-0892');
        $this->assertEquals('Ideell förening eller stiftelse', $id->getGroupDescription());

        $id = new CorporateId('916452-6197');
        $this->assertEquals('Handelsbolag, kommanditbolag eller enkelt bolag', $id->getGroupDescription());

        $id = new CorporateId('132100-0018');
        $this->assertEquals('Okänd', $id->getGroupDescription());
    }
}
