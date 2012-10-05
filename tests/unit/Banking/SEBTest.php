<?php
namespace itbz\stb\Banking;

class SEBTest extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
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
     * @expectedException \itbz\stb\Exception\InvalidClearingException
     * @dataProvider invalidClearingProvider
     */
    public function testInvalidClearing($nr)
    {
        new SEB($nr);
    }

    public function invalidStructuresProvider()
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
     * @expectedException \itbz\stb\Exception\InvalidStructureException
     */
    public function testInvalidStructure($nr)
    {
        new SEB($nr);
    }

    public function invalidCheckDigitProvider()
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
     * @expectedException \itbz\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidCheckDigit($nr)
    {
        new SEB($nr);
    }

    public function validProvider()
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
    public function testConstruct($nr)
    {
        new SEB($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new SEB('5000,000001111116');
        $this->assertEquals((string)$m, '5000,1111116');
    }

    public function testTo16()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->to16(), '5000000001111116');
    }

    public function testGetClearing()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getClearing(), '5000');
    }

    public function testGetNumber()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getNumber(), '1111116');
        $m = new SEB('5000,001111116');
        $this->assertEquals($m->getNumber(), '001111116');
    }

    public function testGetType()
    {
        $m = new SEB('5000,1111116');
        $this->assertEquals($m->getType(), 'SEB');
    }
}
