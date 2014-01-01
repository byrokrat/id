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

class InvoiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException iio\stb\Exception
     */
    public function testGetSerialException()
    {
        $builder = new InvoiceBuilder();
        $builder->getSerial();
    }

    /**
     * @expectedException iio\stb\Exception
     */
    public function testGetSellerException()
    {
        $builder = new InvoiceBuilder();
        $builder->getSeller();
    }

    /**
     * @expectedException iio\stb\Exception
     */
    public function testGetBuyerException()
    {
        $builder = new InvoiceBuilder();
        $builder->getBuyer();
    }

    public function testSetGetBillDate()
    {
        $builder = new InvoiceBuilder();
        $date = new DateTime();

        $builder->setBillDate($date);
        $this->assertSame($date, $builder->getBillDate());

        $builder->reset();

        $this->assertNotSame($date, $builder->getBillDate());
    }

    /**
     * @expectedException iio\stb\Exception
     */
    public function testGetOcrException()
    {
        $builder = new InvoiceBuilder();
        $builder->getOCR();
    }

    public function testSetGetGenerateOCR()
    {
        $builder = new InvoiceBuilder();
        $ocr = new OCR('232');

        $builder->setOCR($ocr);
        $this->assertSame($ocr, $builder->getOCR());

        $builder->reset()->generateOCR()->setSerial('1');

        $this->assertEquals(new OCR('133'), $builder->getOCR());
    }

    public function testGetInvoice()
    {
        $builder = new InvoiceBuilder();

        $invoice = $builder->reset()
            ->setSerial('1')
            ->generateOCR()
            ->setSeller(new LegalPerson('seller'))
            ->setBuyer(new LegalPerson('buyer'))
            ->setPaymentTerm(1)
            ->setDeduction(new Amount('100'))
            ->setMessage('message')
            ->setCurrency('EUR')
            ->addPost(new InvoicePost('', new Amount, new Amount))
            ->getInvoice();

        $this->assertEquals('message', $invoice->getMessage());
        $this->assertEquals('EUR', $invoice->getCurrency());
    }
}
