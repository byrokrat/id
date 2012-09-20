<?php
namespace itbz\STB\Utils;


class OCRTest extends \PHPUnit_Framework_TestCase
{

    function testCreate()
    {
        $o = new OCR();
        $this->assertEquals('12345682', (string)$o->create('123456'));
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     */
    function testCreateInvalidLength()
    {
        $o = new OCR();
        $o->create('123456789012345678901234');
    }

    
    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     */
    function testCreateNotNumeric()
    {
        $o = new OCR();
        $o->create('123L');
    }


    function testSetGet()
    {
        $o = new OCR();
        $this->assertSame('', $o->get());
        $this->assertSame('', (string)$o);

        $o->set('12345682');
        $this->assertSame('12345682', $o->get());
        $this->assertSame('12345682', (string)$o);

        $o = new OCR('12345682');
        $this->assertSame('12345682', $o->get());
        $this->assertSame('12345682', (string)$o);
    }


    function invalidStructuresProvider()
    {
        return array(
            array(123),
            array('a'),
            array('1'),
            array('12345678901234567890123456'),
        );
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     * @dataProvider invalidStructuresProvider
     */
    function testSetInvalidStructure($ocr)
    {
        $o = new OCR($ocr);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidLengthDigitException
     */
    function testSetInvalidLengthDigit()
    {
        $o = new OCR('12345602');
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidCheckDigitException
     */
    function testSetInvalidCheckDigit()
    {
        $o = new OCR('12345680');
    }

}
