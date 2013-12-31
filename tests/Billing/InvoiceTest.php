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
use DateTime;

class InvoiceTest extends \PHPUnit_Framework_TestCase
{
    private function getInvoice()
    {
        return new Invoice(
            '1',
            new LegalPerson('seller'),
            new LegalPerson('buyer'),
            new DateTime('2014-01-01'),
            new OCR('133'),
            $this->getPosts(),
            'message',
            1,
            new Amount ('100'),
            'SEK'
        );
    }

    private function getPosts()
    {
        return array(
            new InvoicePost(
                '',
                new Amount('1'),
                new Amount('100', 2),
                new Amount('.25', 2)
            ),
            new InvoicePost(
                '',
                new Amount('2'),
                new Amount('50', 2),
                new Amount('0', 2) 
            )
        );
    }

    public function testGetPosts()
    {
        $this->assertEquals($this->getPosts(), $this->getInvoice()->getPosts());
    }

    public function testGetVatTotal()
    {
        $this->assertEquals('25', (string)$this->getInvoice()->getVatTotal());
    }

    public function testGetUnitTotal()
    {
        $this->assertEquals('200', (string)$this->getInvoice()->getUnitTotal());
    }

    public function testGetInvoiceTotal()
    {
        $this->assertEquals('125', (string)$this->getInvoice()->getInvoiceTotal());
    }

    public function testGetVatRates()
    {
        // Second post has VAT 0 and should not be included
        $rates = $this->getPosts();
        array_pop($rates);

        $this->assertEquals($rates, $this->getInvoice()->getVatRates());
    }

    public function testGetSerial()
    {
        $this->assertEquals('1', $this->getInvoice()->getSerial());
    }

    public function testGetSeller()
    {
        $this->assertEquals('seller', $this->getInvoice()->getSeller()->getName());
    }

    public function testGetBuyer()
    {
        $this->assertEquals('buyer', $this->getInvoice()->getBuyer()->getName());
    }

    public function testGetBillDate()
    {
        $this->assertEquals(new DateTime('2014-01-01'), $this->getInvoice()->getBillDate());
    }

    public function testGetOcr()
    {
        $this->assertEquals(new OCR('133'), $this->getInvoice()->getOCR());
    }

    public function testGetMessage()
    {
        $this->assertEquals('message', $this->getInvoice()->getMessage());
    }

    public function testGetPaymentTerm()
    {
        $this->assertEquals(1, $this->getInvoice()->getPaymentTerm());
    }

    public function testGetExpirationDate()
    {
        $this->assertEquals(new DateTime('2014-01-02'), $this->getInvoice()->getExpirationDate());
    }

    public function testGetDeduction()
    {
        $this->assertEquals(new Amount('100'), $this->getInvoice()->getDeduction());
    }

    public function testGetCurrency()
    {
        $this->assertEquals('SEK', $this->getInvoice()->getCurrency());
    }
}
