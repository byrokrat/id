<?php
namespace itbz\STB\Utils;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class AmountTest extends \PHPUnit_Framework_TestCase
{

    function testSetFloat()
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


    function testSetString()
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


    function testConstruct()
    {
        $a = new Amount(123.23, 2);
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


    function testSetSignalString()
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


    function testAdd()
    {
        $a = new Amount('100', 2);

        $a->add(new Amount('50'));
        $this->assertSame('150.00', $a->getString());

        $a->add(new Amount('-100'));
        $this->assertSame('50.00', $a->getString());

        $a->add(new Amount('-100'));
        $this->assertSame('-50.00', $a->getString());
    }


    function testSubtract()
    {
        $a = new Amount('99');
        $a->subtract(new Amount('100.50'));
        $a->setPrecision(2);
        $this->assertSame('-1.50', $a->getString());
    }


    function testInvert()
    {
        $a = new Amount('50.50');
        $a->invert();
        $a->setPrecision(2);
        $this->assertSame('-50.50', $a->getString());
    }


    function testPrecision()
    {
        $a = new Amount('35', 10);
        $b = new Amount('-34.99');
        $a->add($b);
        $this->assertSame('0.0100000000', $a->getString());
    }


    function testGetPrecision()
    {
        $a = new Amount('0', 2);
        $this->assertSame(2, $a->getPrecision());
    }


    function testEqualsLesserGreaterThan()
    {
        $a = new Amount('100');

        $this->assertTrue($a->equals(new Amount('100')));
        $this->assertTrue($a->isLesserThan(new Amount('150')));
        $this->assertTrue($a->isGreaterThan(new Amount('50')));

        $this->assertFalse($a->equals(new Amount('1000')));
        $this->assertFalse($a->isLesserThan(new Amount('50')));
        $this->assertFalse($a->isGreaterThan(new Amount('150')));
    }


    function testSetEmptyString()
    {
        $a = new Amount('');
        $this->assertTrue($a->equals(new Amount(0.0)));
    }


    function testFormat()
    {
        $a = new Amount('10000.5', 2);
        $this->assertSame('10000.50', $a->format('%!^n'));
    }


    function testSetLocaleString()
    {
        $a = new Amount('0', 2);
        $a->setLocaleString('10000.00');
        $this->assertSame('10000.00', $a->getRawString());
        $a->setLocaleString('-10 000,00', ',', ' ');
        $this->assertSame('-10000.00', $a->getRawString());
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAmountException
     */
    function testInvalidAmount()
    {
        new Amount(NULL);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAmountException
     */
    function testInvalidFloat()
    {
        $a = new Amount();
        $a->setFloat(1);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAmountException
     */
    function testInvalidInt()
    {
        $a = new Amount();
        $a->setInt(1.0);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAmountException
     */
    function testInvalidString()
    {
        $a = new Amount();
        $a->setString('sdf');
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidAmountException
     */
    function testInvalidSignal()
    {
        $a = new Amount();
        $a->setSignalString('Q123Q');
    }

}
