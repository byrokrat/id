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
