<?php
namespace itbz\STB\Banking;


class BankgiroTest extends \PHPUnit_Framework_TestCase
{

    function validProvider()
    {
        return array(
            array('5050-1055'),
            array('5897-5616'),
            array('784-8419'),
            array('5331-1338'),
            array('5645-2725'),
            array('5588-8077'),
            array('5694-8227'),
            array('5805-6201'),
        );
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('5050-1050'),
            array('5897-5610'),
            array('784-8410'),
            array('5331-1330'),
            array('5645-2720'),
            array('5588-8070'),
            array('5694-8220'),
            array('5805-6200'),
        );
    }


    function invalidStructuresProvider()
    {
        return array(
            array('-1234'),
            array('1-1234'),
            array('12-1234'),
            array('12345-1234'),
            array('123'),
            array('123-'),
            array('123-1'),
            array('123-12'),
            array('123-123'),
            array('123-12345'),
            array(''),
        );
    }


    /**
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     */
    function testInvalidClearing()
    {
        $m = new Bankgiro('1234,5805-6200');
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($num)
    {
        $m = new Bankgiro($num);
        $this->assertTrue(TRUE);
    }


    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidStructure($num)
    {
        $m = new Bankgiro($num);
    }


    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\STB\Exception\InvalidCheckDigitException
     */
    function testInvalidCheckDigit($num)
    {
        $m = new Bankgiro($num);
    }


    function testToString()
    {
        $m = new Bankgiro('5050-1055');
        $this->assertEquals((string)$m, '5050-1055');
    }


    function testGetType()
    {
        $m = new Bankgiro('5050-1055');
        $this->assertEquals($m->getType(), 'Bankgiro');
    }

}
