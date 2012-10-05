<?php
namespace itbz\stb\Banking;

class NordeaTyp1ATest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('1099,1'),
            array('1200,1'),
            array('1399,1'),
            array('2100,1'),
            array('2999,1'),
            array('3300,1'),
            array('3400,1'),
            array('3409,1'),
            array('3782,1'),
            array('4000,1'),
        );
    }

    /**
     * @expectedException \itbz\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new NordeaTyp1A($nr);
    }

    public function invalidStructuresProvider()
    {
        return array(
            array('3000,111111'),
            array('3000,11111'),
            array('3000,11111111'),
            array('3000,0000001111111'),
        );
    }

    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \itbz\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($nr)
    {
        new NordeaTyp1A($nr);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('3000,1111111'),
            array('3032,0050011'),
            array('3017,0108601'),
            array('3030,0377311'),
            array('1405,3542562'),
            array('3045,0147421'),
            array('3045,0156691'),
        );
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($nr)
    {
        new NordeaTyp1A($nr);
    }

    public function validProvider()
    {
        return array(
            array('3000,1111116'),
            array('3000,000001111116'),
            array('3032,0050017'),
            array('3017,0108600'),
            array('3030,0377312'),
            array('1405,3542561'),
            array('3045,0147428'),
            array('3045,0156699'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new NordeaTyp1A($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new NordeaTyp1A('3000,000001111116');
        $this->assertEquals((string)$m, '3000,1111116');
    }

    public function testTo16()
    {
        $m = new NordeaTyp1A('3000,1111116');
        $this->assertEquals($m->to16(), '3000000001111116');
    }

    public function testGetType()
    {
        $m = new NordeaTyp1A('3000,1111116');
        $this->assertEquals($m->getType(), 'Nordea');
    }
}
