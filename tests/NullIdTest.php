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

class NullIdTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCheckDigit()
    {
        $id = new NullId();
        $this->assertEquals('0', $id->getCheckDigit());
    }

    public function testGetDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('-', $id->getDelimiter());
    }

    public function testGetString()
    {
        NullId::setString('foobar');
        $id = new NullId();
        $this->assertEquals('foobar', (string)$id);
        $this->assertEquals('foobar', $id->getId());
    }
}
