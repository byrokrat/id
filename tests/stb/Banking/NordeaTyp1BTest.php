<?php
namespace itbz\STB\Banking;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class NordeaTyp1BTest extends \PHPUnit_Framework_TestCase
{

    function invalidClearingProvider()
    {
        return array(
            array('3999,1'),
            array('5000,1'),
        );
    }


    /**
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    function testInvalidClearing($nr)
    {
        $m = new NordeaTyp1B($nr);
    }


    function invalidStructuresProvider()
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
     * @expectedException \itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidStructure($nr)
    {
        $m = new NordeaTyp1B($nr);
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('4000,1111111'),
        );
    }


    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\STB\Exception\InvalidCheckDigitException
     */
    function testInvalidCheckDigit($nr)
    {
        $m = new NordeaTyp1B($nr);
    }


    function validProvider()
    {
        return array(
            array('4000,1111112'),
            array('4000,000001111112'),
        );
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($nr)
    {
        $m = new NordeaTyp1B($nr);
        $this->assertTrue(TRUE);
    }


    function testToString()
    {
        $m = new NordeaTyp1B('4000,000001111112');
        $this->assertEquals((string)$m, '4000,1111112');
    }


    function testTo16()
    {
        $m = new NordeaTyp1B('4000,1111112');
        $this->assertEquals($m->to16(), '4000000001111112');
    }


    function testGetType()
    {
        $m = new NordeaTyp1B('4000,1111112');
        $this->assertEquals($m->getType(), 'Nordea');
    }

}
