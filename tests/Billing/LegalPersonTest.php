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

namespace iio\stb\Billing;

use iio\stb\ID\CorporateId;
use iio\stb\Banking\Bankgiro;

class LegalPersonTest extends \PHPUnit_Framework_TestCase
{
    private function make()
    {
        return new LegalPerson(
            'Name',
            new CorporateId('777777-7777'),
            new Bankgiro('111-1111'),
            '1234',
            true,
            true
        );
    }

    public function testGetName()
    {
        $this->assertEquals('Name', $this->make()->getName());
    }

    public function testGetId()
    {
        $this->assertEquals(new CorporateId('777777-7777'), $this->make()->getId());
    }

    public function testGetAccount()
    {
        $this->assertEquals(new Bankgiro('111-1111'), $this->make()->getAccount());
    }

    public function testGetCustomerNumber()
    {
        $this->assertEquals('1234', $this->make()->getCustomerNumber());
    }

    public function testIsCorporation()
    {
        $this->assertTrue($this->make()->isCorporation());
    }

    public function testGetVatNr()
    {
        $this->assertEquals('SE777777777701', $this->make()->getVatNr());
    }
}
