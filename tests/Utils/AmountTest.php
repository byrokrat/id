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

namespace iio\stb\Utils;

class AmountTest extends \PHPUnit_Framework_TestCase
{
    public function testSetFloat()
    {
        $a = new Amount('0', 2);

        $a->setFloat(123.23);
        $this->assertSame(123.23, $a->getFloat());
        $this->assertSame("123.23", $a->getString());
        $this->assertSame("123.23", (string)$a);
        $this->assertSame("12323", $a->getSignalString());

        $a->setFloat(123.0);
        $this->assertSame(123.00, $a->getFloat());
        $this->assertSame("123.00", $a->getString());
        $this->assertSame("123.00", (string)$a);
        $this->assertSame("12300", $a->getSignalString());

        $a->setFloat(123.111);
        $this->assertSame(123.11, $a->getFloat());
        $this->assertSame("123.11", $a->getString());
        $this->assertSame("123.11", (string)$a);
        $this->assertSame("12311", $a->getSignalString());

        $a->setFloat(123.119);
        $this->assertSame(123.12, $a->getFloat());
        $this->assertSame("123.11", $a->getString());
        $this->assertSame("123.11", (string)$a);
        $this->assertSame("12311", $a->getSignalString());

        $a->setFloat(-123.20);
        $this->assertSame(-123.20, $a->getFloat());
        $this->assertSame("-123.20", $a->getString());
        $this->assertSame("-123.20", (string)$a);
        $this->assertSame("1232å", $a->getSignalString());

        $a->setFloat(-123.111);
        $this->assertSame(-123.11, $a->getFloat());
        $this->assertSame("-123.11", $a->getString());
        $this->assertSame("-123.11", (string)$a);
        $this->assertSame("1231J", $a->getSignalString());

        $a->setFloat(-123.119);
        $this->assertSame(-123.12, $a->getFloat());
        $this->assertSame("-123.11", $a->getString());
        $this->assertSame("-123.11", (string)$a);
        $this->assertSame("1231J", $a->getSignalString());
    }

    public function testSetInt()
    {
        $a = new Amount();
        $a->setInt(100);
        $this->assertSame(100, $a->getInt());
    }

    public function testSetString()
    {
        $a = new Amount('0', 2);

        $a->setString('123.23');
        $this->assertSame(123.23, $a->getFloat());
        $this->assertSame("123.23", $a->getString());
        $this->assertSame("123.23", (string)$a);
        $this->assertSame("12323", $a->getSignalString());

        $a->setString('123.0');
        $this->assertSame(123.00, $a->getFloat());
        $this->assertSame("123.00", $a->getString());
        $this->assertSame("123.00", (string)$a);
        $this->assertSame("12300", $a->getSignalString());

        $a->setString('123.111');
        $this->assertSame(123.11, $a->getFloat());
        $this->assertSame("123.11", $a->getString());
        $this->assertSame("123.11", (string)$a);
        $this->assertSame("12311", $a->getSignalString());

        $a->setString('123.119');
        $this->assertSame(123.12, $a->getFloat());
        $this->assertSame("123.11", $a->getString());
        $this->assertSame("123.11", (string)$a);
        $this->assertSame("12311", $a->getSignalString());

        $a->setString('-123.23');
        $this->assertSame(-123.23, $a->getFloat());
        $this->assertSame("-123.23", $a->getString());
        $this->assertSame("-123.23", (string)$a);
        $this->assertSame("1232L", $a->getSignalString());

        $a->setString('-123.141');
        $this->assertSame(-123.14, $a->getFloat());
        $this->assertSame("-123.14", $a->getString());
        $this->assertSame("-123.14", (string)$a);
        $this->assertSame("1231M", $a->getSignalString());

        $a->setString('-123.149');
        $this->assertSame(-123.15, $a->getFloat());
        $this->assertSame("-123.14", $a->getString());
        $this->assertSame("-123.14", (string)$a);
        $this->assertSame("1231M", $a->getSignalString());
    }

    public function testConstruct()
    {
        $a = new Amount('123.23', 2);
        $this->assertSame(123.23, $a->getFloat());
        $this->assertSame("123.23", $a->getString());
        $this->assertSame("123.23", (string)$a);
        $this->assertSame("12323", $a->getSignalString());

        $a = new Amount("123.23", 2);
        $this->assertSame(123.23, $a->getFloat());
        $this->assertSame("123.23", $a->getString());
        $this->assertSame("123.23", (string)$a);
        $this->assertSame("12323", $a->getSignalString());
    }

    public function testSetSignalString()
    {
        $a = new Amount('0', 2);

        $a->setSignalString('23');
        $this->assertSame(0.23, $a->getFloat());
        $this->assertSame("0.23", $a->getString());
        $this->assertSame("0.23", (string)$a);
        $this->assertSame("023", $a->getSignalString());

        $a->setSignalString('12300');
        $this->assertSame(123.00, $a->getFloat());
        $this->assertSame("123.00", $a->getString());
        $this->assertSame("123.00", (string)$a);
        $this->assertSame("12300", $a->getSignalString());

        $a->setSignalString('1232O');
        $this->assertSame(-123.26, $a->getFloat());
        $this->assertSame("-123.26", $a->getString());
        $this->assertSame("-123.26", (string)$a);
        $this->assertSame("1232O", $a->getSignalString());

        $a->setSignalString('1232P');
        $this->assertSame(-123.27, $a->getFloat());
        $this->assertSame("-123.27", $a->getString());
        $this->assertSame("-123.27", (string)$a);
        $this->assertSame("1232P", $a->getSignalString());

        $a->setSignalString('1232Q');
        $this->assertSame(-123.28, $a->getFloat());
        $this->assertSame("-123.28", $a->getString());
        $this->assertSame("-123.28", (string)$a);
        $this->assertSame("1232Q", $a->getSignalString());

        $a->setSignalString('1232R');
        $this->assertSame(-123.29, $a->getFloat());
        $this->assertSame("-123.29", $a->getString());
        $this->assertSame("-123.29", (string)$a);
        $this->assertSame("1232R", $a->getSignalString());
    }

    public function testAdd()
    {
        $a = new Amount('100', 2);

        $a->add(new Amount('50'));
        $this->assertSame('150.00', $a->getString());

        $a->add(new Amount('-100'));
        $this->assertSame('50.00', $a->getString());

        $a->add(new Amount('-100'));
        $this->assertSame('-50.00', $a->getString());
    }

    public function testSubtract()
    {
        $a = new Amount('99');
        $a->subtract(new Amount('100.50'));
        $a->setPrecision(2);
        $this->assertSame('-1.50', $a->getString());
    }

    public function testMultiplyWith()
    {
        $a = new Amount('10');
        $a->multiplyWith(new Amount('10'));
        $a->setPrecision(0);
        $this->assertSame('100', $a->getString());
    }

    public function testDivideBy()
    {
        $a = new Amount('10');
        $a->divideBy(new Amount('10'));
        $a->setPrecision(0);
        $this->assertSame('1', $a->getString());
    }

    public function testInvert()
    {
        $a = new Amount('50.50');
        $a->invert();
        $a->setPrecision(2);
        $this->assertSame('-50.50', $a->getString());
    }

    public function testPrecision()
    {
        $a = new Amount('35', 10);
        $b = new Amount('-34.99');
        $a->add($b);
        $this->assertSame('0.0100000000', $a->getString());
    }

    public function testGetPrecision()
    {
        $a = new Amount();
        $a->setPrecision(10);
        $this->assertSame(10, $a->getPrecision());

        setlocale(LC_MONETARY, 'C');
        $a = new Amount();
        $this->assertSame(2, $a->getPrecision());
    }

    public function testEqualsLesserGreaterThan()
    {
        $a = new Amount('100');

        $this->assertTrue($a->equals(new Amount('100')));
        $this->assertTrue($a->isLesserThan(new Amount('150')));
        $this->assertTrue($a->isGreaterThan(new Amount('50')));

        $this->assertFalse($a->equals(new Amount('1000')));
        $this->assertFalse($a->isLesserThan(new Amount('50')));
        $this->assertFalse($a->isGreaterThan(new Amount('150')));
    }

    public function testSetEmptyString()
    {
        $a = new Amount('');
        $this->assertTrue($a->equals(new Amount('0.0')));
    }

    public function testFormat()
    {
        $a = new Amount('10000.5', 2);
        $this->assertSame('10000.50', $a->format('%!^n'));
    }

    public function testSetLocaleString()
    {
        $a = new Amount('0', 2);
        $a->setLocaleString('10000.00');
        $this->assertSame('10000.00', $a->getRawString());
        $a->setLocaleString('-10 000,00', ',', ' ');
        $this->assertSame('-10000.00', $a->getRawString());
    }

    /**
     * @expectedException iio\stb\Exception\InvalidAmountException
     */
    public function testInvalidAmount()
    {
        new Amount(null);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidAmountException
     */
    public function testInvalidFloat()
    {
        $a = new Amount();
        $a->setFloat(1);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidAmountException
     */
    public function testInvalidInt()
    {
        $a = new Amount();
        $a->setInt(1.0);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidAmountException
     */
    public function testInvalidString()
    {
        $a = new Amount();
        $a->setString('sdf');
    }

    /**
     * @expectedException iio\stb\Exception\InvalidAmountException
     */
    public function testInvalidSignal()
    {
        $a = new Amount();
        $a->setSignalString('Q123Q');
    }
}
