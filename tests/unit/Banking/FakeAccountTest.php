<?php
namespace itbz\STB\Banking;


class FakeAccountTest extends \PHPUnit_Framework_TestCase
{

    function invalidClearingProvider()
    {
        return array(
            array('915,1'),
            array('91115,1'),
        );
    }


    /**
     * @expectedException \itbz\STB\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    function testInvalidClearing($nr)
    {
        $m = new FakeAccount($nr);
    }


    function validProvider()
    {
        return array(
            array('5000,1111116'),
            array('5000,000001111116'),
        );
    }


    /**
     * @dataProvider validProvider
     */
    function testConstruct($nr)
    {
        $m = new FakeAccount($nr);
        $this->assertTrue(TRUE);
    }


    function testToString()
    {
        $m = new FakeAccount('5000,000001111116');
        $this->assertEquals((string)$m, '5000,000001111116');
    }


    function testTo16()
    {
        $m = new FakeAccount('5000,1111116');
        $this->assertEquals($m->to16(), '5000000001111116');
    }


    function testGetType()
    {
        $m = new FakeAccount('5000,1111116');
        $this->assertEquals($m->getType(), 'Unknown');
    }

}
