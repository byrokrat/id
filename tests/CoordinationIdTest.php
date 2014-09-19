<?php

namespace ledgr\id;

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
     * @expectedException ledgr\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new CoordinationId($nr);
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
     * @expectedException ledgr\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($nr)
    {
        new CoordinationId($nr);
    }

    public function interchangeableFormulasProvider()
    {
        return array(
            array(new CoordinationId('701063-2391'), new CoordinationId('7010632391')),
            array(new CoordinationId('19701063-2391'), new CoordinationId('197010632391')),
            array(new CoordinationId('19701063-2391'), new CoordinationId('19701063+2391'))
        );
    }

    /**
     * @dataProvider interchangeableFormulasProvider
     */
    public function testInterchangeableFormulas($a, $b)
    {
        $this->assertEquals($a, $b);
    }

    public function testGetCentry()
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

    public function testGetDate()
    {
        $this->assertEquals(
            '1970-10-03',
            (new CoordinationId('701063-2391'))->getDate()->format('Y-m-d')
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            '701063-2391',
            (string) new CoordinationId('701063-2391')
        );
    }
}
