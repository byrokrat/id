<?php
namespace itbz\STB\Banking;


class SwedbankTyp2Test extends \PHPUnit_Framework_TestCase
{

    function invalidClearingProvider()
    {
        return array(
            array('7999,1'),
            array('9000,1'),
        );
    }


    /**
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    function testInvalidClearing($nr)
    {
        $m = new SwedbankTyp2($nr);
    }


    function invalidStructuresProvider()
    {
        return array(
            array('8000,1'),
            array('8000,11111111111'),
            array('8000,0001111111111'),
        );
    }


    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidStructure($nr)
    {
        $m = new SwedbankTyp2($nr);
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('8000,1111112'),
            array('8214,9837107772'),
            array('8150,9942266951'),
            array('8327,9940298181'),
            array('8214,9846665701'),
            array('8214,9844447351'),
            array('8006,5330010161'),
            array('8424,39984101'),
            array('8150,9942187552'),
            array('8214,9133844001'),
        );
    }


    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\STB\Exception\InvalidCheckDigitException
     */
    function testInvalidCheckDigit($nr)
    {
        $m = new SwedbankTyp2($nr);
    }


    function validProvider()
    {
        return array(
            array('8000,1111111'),
            array('8000,000001111111'),
            array('8214,9837107771'),
            array('8150,9942266959'),
            array('8327,9940298186'),
            array('8214,9846665702'),
            array('8214,9844447350'),
            array('8006,5330010165'),
            array('8424,39984109'),
            array('8150,9942187551'),
            array('8214,9133844002'),
        );
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($nr)
    {
        $m = new SwedbankTyp2($nr);
        $this->assertTrue(TRUE);
    }


    function testToString()
    {
        $m = new SwedbankTyp2('8000,001111111116');
        $this->assertEquals('8000,1111111116', (string)$m);
    }


    function testGetType()
    {
        $m = new SwedbankTyp2('8000,1111111');
        $this->assertEquals($m->getType(), 'Swedbank');
    }

}
