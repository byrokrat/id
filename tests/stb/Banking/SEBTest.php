<?php
namespace itbz\STB\Banking;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class SEBTest extends \PHPUnit_Framework_TestCase
{

    function invalidClearingProvider()
    {
        return array(
            array('4999,1'),
            array('6000,1'),
            array('9119,1'),
            array('9125,1'),
            array('9129,1'),
            array('9150,1'),
        );
    }


    /**
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    function testInvalidClearing($nr)
    {
        $m = new SEB($nr);
    }


    function invalidStructuresProvider()
    {
        return array(
            array('5000,111111'),
            array('5000,11111'),
            array('5000,11111111'),
            array('5000,0000001111111'),
        );
    }


    /**
     * @dataProvider invalidStructuresProvider
     * @expectedException \itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidStructure($nr)
    {
        $m = new SEB($nr);
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('5000,1111111'),
            array('5681,0047150'),
            array('5102,0158750'),
            array('5624,0179270'),
            array('5011,0137390'),
            array('5169,0027450'),
            array('5007,0042700'),
            array('5502,0038521'),
            array('5504,0017150'),
            array('5624,0017790'),
        );
    }


    /**
     * @dataProvider invalidCheckDigitProvider
     * @expectedException \itbz\STB\Exception\InvalidCheckDigitException
     */
    function testInvalidCheckDigit($nr)
    {
        $m = new SEB($nr);
    }


    function validProvider()
    {
        return array(
            array('5000,1111116'),
            array('5000,000001111116'),
            array('5681,0047158'),
            array('5102,0158751'),
            array('5624,0179272'),
            array('5011,0137396'),
            array('5169,0027452'),
            array('5007,0042705'),
            array('5502,0038520'),
            array('5504,0017154'),
            array('5624,0017795'),
        );
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($nr)
    {
        $m = new SEB($nr);
        $this->assertTrue(TRUE);
    }


    function testToString()
    {
        $m = new SEB('5000,000001111116');
        $this->assertEquals((string)$m, '5000,1111116');
    }


    function testTo16()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->to16(), '5000000001111116');
    }


    function testGetClearing()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getClearing(), '5000');
    }


    function testGetNumber()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getNumber(), '1111116');
        $m = new SEB('5000,001111116');
        $this->assertEquals($m->getNumber(), '001111116');
    }


    function testGetType()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getType(), 'SEB');
    }

}
