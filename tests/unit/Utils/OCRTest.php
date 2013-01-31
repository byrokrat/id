<?php
namespace iio\stb\Utils;

class OCRTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $o = new OCR();
        $this->assertEquals('12345682', (string)$o->create('123456'));
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     */
    public function testCreateInvalidLength()
    {
        $o = new OCR();
        $o->create('123456789012345678901234');
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     */
    public function testCreateNotNumeric()
    {
        $o = new OCR();
        $o->create('123L');
    }

    public function testSetGet()
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

    public function invalidStructuresProvider()
    {
        return array(
            array(123),
            array('a'),
            array('1'),
            array('12345678901234567890123456'),
        );
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     * @dataProvider invalidStructuresProvider
     */
    public function testSetInvalidStructure($ocr)
    {
        new OCR($ocr);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidLengthDigitException
     */
    public function testSetInvalidLengthDigit()
    {
        new OCR('12345602');
    }

    /**
     * @expectedException iio\stb\Exception\InvalidCheckDigitException
     */
    public function testSetInvalidCheckDigit()
    {
        new OCR('12345680');
    }
}
