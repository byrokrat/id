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

class IdFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testPersonalIdFactory()
    {
        $factory = new PersonalIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\PersonalId',
            $factory->create('820323-2775')
        );
    }

    public function testCoordinationIdFactory()
    {
        $factory = new CoordinationIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\CoordinationId',
            $factory->create('701063-2391')
        );
    }

    public function testCorporateIdFactory()
    {
        $factory = new CorporateIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\CorporateId',
            $factory->create('702001-7781')
        );
    }

    public function testFakeIdFactory()
    {
        $factory = new FakeIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\FakeId',
            $factory->create('701023-xxxx')
        );
    }

    /**
     * @expectedException ledgr\id\Exception
     */
    public function testDecoration()
    {
        $factory = new CorporateIdFactory(
            new FakeIdFactory(
                new PersonalIdFactory(
                    new CoordinationIdFactory()
                )
            )
        );
        $factory->create('unvalid id');
    }
}
