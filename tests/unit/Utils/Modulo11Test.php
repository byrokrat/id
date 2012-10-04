<?php
namespace itbz\STB\Utils;

class Modulo11Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     * @dataProvider testVerifyStructureProvider
     */
    public function testVerifyStructure($nr)
    {
        $m = new Modulo11();
        $m->verify($nr);
    }

    public function testVerifyStructureProvider()
    {
        return array(
            array('y'),
            array(''),
            array('1234x'),
            array('X2'),
            array(1234),
            array('1234.234'),
        );
    }

    public function testVerify()
    {
        $m = new Modulo11();

        // Valid check digits
        $this->assertTrue($m->verify('0365327'));
        $this->assertTrue($m->verify('3928444042'));
        $this->assertTrue($m->verify('0131391399'));
        $this->assertTrue($m->verify('007007013X'));
        $this->assertTrue($m->verify('013139139119'));
        $this->assertTrue($m->verify('0365300'));

        // Invalid ckeck digits
        $this->assertFalse($m->verify('0365321'));
        $this->assertFalse($m->verify('3928444041'));
        $this->assertFalse($m->verify('0131391391'));
        $this->assertFalse($m->verify('0070070131'));
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     * @dataProvider testGetCheckDigitStructureProvider
     */
    public function testGetCheckDigitStructure($nr)
    {
        $m = new Modulo11();
        $m->getCheckDigit($nr);
    }

    public function testGetCheckDigitStructureProvider()
    {
        return array(
            array('y'),
            array(''),
            array('X2'),
            array(1234),
            array('123X'),
            array('1234.234'),
        );
    }

    public function testGetCheckDigit()
    {
        $m = new Modulo11();
        $this->assertEquals($m->getCheckDigit('036532'), '7');
        $this->assertEquals($m->getCheckDigit('392844404'), '2');
        $this->assertEquals($m->getCheckDigit('013139139'), '9');
        $this->assertEquals($m->getCheckDigit('01313913911'), '9');
        $this->assertEquals($m->getCheckDigit('007007013'), 'X');
        $this->assertEquals($m->getCheckDigit('036530'), '0');
    }
}
