<?php
namespace iio\stb\Banking;

class PlusGiroTest extends \PHPUnit_Framework_TestCase
{
    public function validProvider()
    {
        return array(
            array('210918-9'),
            array('4395094-8'),
            array('956404-8'),
            array('465658-3'),
            array('205835-2'),
            array('9048-0'),
        );
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('210918-0'),
            array('4395094-0'),
            array('956404-0'),
            array('465658-0'),
            array('205835-0'),
            array('9048-1'),
        );
    }

    public function invalidStructuresProvider()
    {
        return array(
            array('-1'),
            array('-12'),
            array('1-'),
            array('1'),
            array('1-12'),
            array('12345678'),
            array('12345678-1'),
            array('1234567-12'),
        );
    }

    /**
     * @expectedException \iio\stb\Exception\InvalidClearingException
     */
    public function testInvalidClearing()
    {
        new PlusGiro('1234,9048-0');
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($num)
    {
        new PlusGiro($num);
        $this->assertTrue(true);
    }

    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($num)
    {
        new PlusGiro($num);
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($num)
    {
        new PlusGiro($num);
    }

    public function testToString()
    {
        $m = new PlusGiro('9048-0');
        $this->assertEquals((string)$m, '9048-0');
    }

    public function testGetType()
    {
        $m = new PlusGiro('9048-0');
        $this->assertEquals($m->getType(), 'PlusGiro');
    }
}
