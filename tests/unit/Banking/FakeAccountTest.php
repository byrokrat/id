<?php
namespace itbz\stb\Banking;

class FakeAccountTest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
    {
        return array(
            array('915,1'),
            array('91115,1'),
        );
    }

    /**
     * @expectedException \itbz\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new FakeAccount($nr);
    }

    public function validProvider()
    {
        return array(
            array('5000,1111116'),
            array('5000,000001111116'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testConstruct($nr)
    {
        new FakeAccount($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new FakeAccount('5000,000001111116');
        $this->assertEquals((string)$m, '5000,000001111116');
    }

    public function testTo16()
    {
        $m = new FakeAccount('5000,1111116');
        $this->assertEquals($m->to16(), '5000000001111116');
    }

    public function testGetType()
    {
        $m = new FakeAccount('5000,1111116');
        $this->assertEquals($m->getType(), 'Unknown');
    }
}
