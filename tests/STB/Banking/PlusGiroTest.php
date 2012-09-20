<?php
namespace itbz\STB\Banking;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class PlusGiroTest extends \PHPUnit_Framework_TestCase
{

    function validProvider()
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


    function invalidCheckDigitProvider()
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


    function invalidStructuresProvider()
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
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     */
    function testInvalidClearing()
    {
        $m = new PlusGiro('1234,9048-0');
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($num)
    {
        $m = new PlusGiro($num);
        $this->assertTrue(TRUE);
    }


    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidStructure($num)
    {
        $m = new PlusGiro($num);
    }


    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\STB\Exception\InvalidCheckDigitException
     */
    function testInvalidCheckDigit($num)
    {
        $m = new PlusGiro($num);
    }


    function testToString()
    {
        $m = new PlusGiro('9048-0');
        $this->assertEquals((string)$m, '9048-0');
    }


    function testGetType()
    {
        $m = new PlusGiro('9048-0');
        $this->assertEquals($m->getType(), 'PlusGiro');
    }

}
