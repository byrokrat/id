<?php
/**
 * This file is part of ledgr/id.
 *
 * Copyright (c) 2014 Hannes Forsgård
 *
 * ledgr/id is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ledgr/id is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ledgr/id.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ledgr\id;

class CoordinationIdTest extends \PHPUnit_Framework_TestCase
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
        );
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('820383-2770'),
            array('820383-2771'),
            array('820383-2775'),
            array('820383-2773'),
            array('820383-2774'),
            array('820383-2776'),
            array('820383-2777'),
            array('820383-2778'),
            array('820383-2779'),
            array('820383+2770'),
            array('820383+2771'),
            array('820383+2775'),
            array('820383+2773'),
            array('820383+2774'),
            array('820383+2776'),
            array('820383+2777'),
            array('820383+2778'),
            array('820383+2779'),
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new CoordinationId($nr);
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($nr)
    {
        new CoordinationId($nr);
    }

    public function testCentry()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('1970', $id->getDate()->format('Y'));

        $id = new CoordinationId('701063+2391');
        $this->assertEquals('1870', $id->getDate()->format('Y'));
    }

    public function testDelimiter()
    {
        $id = new CoordinationId('19701063+2391');
        $this->assertEquals('701063-2391', $id->getId());

        $id = new CoordinationId('18701063-2391');
        $this->assertEquals('701063+2391', $id->getId());
    }

    public function testSex()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('M', $id->getSex());

        $id = new CoordinationId('770374-0345');
        $this->assertEquals('F', $id->getSex());
    }

    public function testDOB()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('1970-10-03', $id->getDOB());
    }

    public function testToString()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('19701063-2391', (string)$id);
    }
}
