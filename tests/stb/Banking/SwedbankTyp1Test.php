<?php
namespace itbz\STB\Banking;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class SwedbankTyp1Test extends \PHPUnit_Framework_TestCase
{

    function invalidClearingProvider()
    {
        return array(
            array('6999,1'),
            array('8000,1'),
        );
    }


    /**
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    function testInvalidClearing($nr)
    {
        $m = new SwedbankTyp1($nr);
    }


    function invalidStructuresProvider()
    {
        return array(
            array('7000,111111'),
            array('7000,11111'),
            array('7000,11111111'),
            array('7000,0000001111111'),
        );
    }


    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidStructure($nr)
    {
        $m = new SwedbankTyp1($nr);
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('7000,1111111'),
            array('7822,1420650'),
            array('7950,1450700'),
        );
    }


    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\STB\Exception\InvalidCheckDigitException
     */
    function testInvalidCheckDigit($nr)
    {
        $m = new SwedbankTyp1($nr);
    }


    function validProvider()
    {
        return array(
            array('7000,1111116'),
            array('7000,000001111116'),
            array('7822,1420654'),
            array('7950,1450708'),
        );
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($nr)
    {
        $m = new SwedbankTyp1($nr);
        $this->assertTrue(TRUE);
    }


    function testToString()
    {
        $m = new SwedbankTyp1('7000,000001111116');
        $this->assertEquals((string)$m, '7000,1111116');
    }


    function testGetType()
    {
        $m = new SwedbankTyp1('7000,1111116');
        $this->assertEquals($m->getType(), 'Swedbank');
    }

}
