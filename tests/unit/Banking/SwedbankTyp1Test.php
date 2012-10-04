<?php
namespace itbz\STB\Banking;

class SwedbankTyp1Test extends \PHPUnit_Framework_TestCase
{
    public function invalidClearingProvider()
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
    public function testInvalidClearing($nr)
    {
        new SwedbankTyp1($nr);
    }

    public function invalidStructuresProvider()
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
    public function testInvalidStructure($nr)
    {
        new SwedbankTyp1($nr);
    }

    public function invalidCheckDigitProvider()
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
    public function testInvalidCheckDigit($nr)
    {
        new SwedbankTyp1($nr);
    }

    public function validProvider()
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
    public function testConstruct($nr)
    {
        new SwedbankTyp1($nr);
        $this->assertTrue(true);
    }

    public function testToString()
    {
        $m = new SwedbankTyp1('7000,000001111116');
        $this->assertEquals((string)$m, '7000,1111116');
    }

    public function testGetType()
    {
        $m = new SwedbankTyp1('7000,1111116');
        $this->assertEquals($m->getType(), 'Swedbank');
    }
}
