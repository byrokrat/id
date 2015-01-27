<?php

namespace byrokrat\id;

class CoordinationIdTest extends \PHPUnit_Framework_TestCase
{
    public function invalidStructureProvider()
    {
        return array(
            array('123456'),
            array('123456-'),
            array('-1234'),
            array('123456-123'),
            array('123456-12345'),
            array('1234567-1234'),
            array('1234567-1234'),
            array('123456-1A34'),
            array('12A456-1234'),
            array('123456+'),
            array('+1234'),
            array('123456+123'),
            array('123456+12345'),
            array('1234567+1234'),
            array('1234567+1234'),
            array('123456+1A34'),
            array('12A456+1234'),
        );
    }

    /**
     * @expectedException byrokrat\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($number)
    {
        new CoordinationId($number);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('820383-2770'),
            array('820383-2771'),
            array('820383-2775'),
            array('820383-2773'),
            array('820383-2774'),
            array('820383-2776'),
            array('820383-2777'),
            array('820383-2778'),
            array('820383-2779'),
            array('820383+2770'),
            array('820383+2771'),
            array('820383+2775'),
            array('820383+2773'),
            array('820383+2774'),
            array('820383+2776'),
            array('820383+2777'),
            array('820383+2778'),
            array('820383+2779'),
        );
    }

    /**
     * @expectedException byrokrat\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($number)
    {
        new CoordinationId($number);
    }

    public function interchangeableFormulasProvider()
    {
        return array(
            array('701063-2391', '7010632391'),
            array('19701063-2391', '197010632391'),
            array('19701063-2391', '19701063+2391')
        );
    }

    /**
     * @dataProvider interchangeableFormulasProvider
     */
    public function testInterchangeableFormulas($numberA, $numberB)
    {
        $this->assertSame(
            (string)new CoordinationId($numberA),
            (string)new CoordinationId($numberB)
        );
    }

    public function testGetDelimiter()
    {
        $this->assertEquals(
            '-',
            (new CoordinationId('19701063+2391'))->getDelimiter()
        );

        $this->assertEquals(
            '+',
            (new CoordinationId('18701063-2391'))->getDelimiter()
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            '701063-2391',
            (string) new CoordinationId('701063-2391')
        );
    }

    public function testGetDate()
    {
        $this->assertEquals(
            '1970-10-03',
            (new CoordinationId('701063-2391'))->getDate()->format('Y\-m\-d')
        );
    }

    public function testGetCentury()
    {
        $this->assertEquals(
            '19',
            (new CoordinationId('701063-2391'))->getCentury()
        );

        $this->assertEquals(
            '18',
            (new CoordinationId('701063+2391'))->getCentury()
        );
    }

    public function testGetSex()
    {
        $this->assertEquals(
            Id::SEX_MALE,
            (new CoordinationId('701063-2391'))->getSex()
        );

        $this->assertEquals(
            Id::SEX_FEMALE,
            (new CoordinationId('770374-0345'))->getSex()
        );
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            Id::COUNTY_UNDEFINED,
            (new CoordinationId('770374-0345'))->getBirthCounty()
        );
    }
}
