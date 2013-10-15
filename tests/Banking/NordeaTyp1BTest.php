<?php
namespace iio\stb\Banking;

class NordeaTyp1BTest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('3999,1'),
            array('5000,1'),
        );
    }

    /**
     * @expectedException \iio\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new NordeaTyp1B($nr);
    }

    public function invalidStructuresProvider()
    {
        return array(
            array('4000,111111'),
            array('4000,11111'),
            array('4000,11111111'),
            array('4000,0000001111111'),
        );
    }

    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($nr)
    {
        new NordeaTyp1B($nr);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('4000,1111111'),
        );
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($nr)
    {
        new NordeaTyp1B($nr);
    }

    public function validProvider()
    {
        return array(
            array('4000,1111112'),
            array('4000,000001111112'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new NordeaTyp1B($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new NordeaTyp1B('4000,000001111112');
        $this->assertEquals((string)$m, '4000,1111112');
    }

    public function testTo16()
    {
        $m = new NordeaTyp1B('4000,1111112');
        $this->assertEquals($m->to16(), '4000000001111112');
    }

    public function testGetType()
    {
        $m = new NordeaTyp1B('4000,1111112');
        $this->assertEquals($m->getType(), 'Nordea');
    }
}
