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

use iio\stb\Utils\Amount;

class InvoicePostTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDescription()
    {
        $p = new InvoicePost('desc', new Amount('2'), new Amount('100'), new Amount('.25'));
        $this->assertEquals('desc', $p->getDescription());
    }

    public function testGetNrOfUnits()
    {
        $p = new InvoicePost('desc', new Amount('2'), new Amount('100'), new Amount('.25'));
        $this->assertEquals(new Amount('2'), $p->getNrOfUnits());
    }

    public function testGetUnitCost()
    {
        $p = new InvoicePost('desc', new Amount('2'), new Amount('100'), new Amount('.25'));
        $this->assertEquals(new Amount('100'), $p->getUnitCost());
    }

    public function testGetUnitTotal()
    {
        $p = new InvoicePost('desc', new Amount('2'), new Amount('100'), new Amount('.25'));
        $this->assertEquals('200', (string)$p->getUnitTotal());
    }

    public function testGetVatRate()
    {
        $p = new InvoicePost('desc', new Amount('2'), new Amount('100'), new Amount('.25'));
        $this->assertEquals(new Amount('.25'), $p->getVatRate());
    }

    public function testGetVatTotal()
    {
        $p = new InvoicePost('desc', new Amount('2'), new Amount('100'), new Amount('.25'));
        $this->assertEquals('50', (string)$p->getVatTotal());
    }
}
