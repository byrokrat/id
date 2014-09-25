<?php

namespace ledgr\id;

class PersonalIdTest extends \PHPUnit_Framework_TestCase
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
            array('120101-A234'),
            array('120101-12345'),
            array('120101+A234'),
            array('120101+12345'),
            array('')
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($number)
    {
        new PersonalId($number);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('820323-2770'),
            array('820323-2771'),
            array('820323-2772'),
            array('820323-2773'),
            array('820323-2774'),
            array('820323-2776'),
            array('820323-2777'),
            array('820323-2778'),
            array('820323-2779'),
            array('820323+2770'),
            array('820323+2771'),
            array('820323+2772'),
            array('820323+2773'),
            array('820323+2774'),
            array('820323+2776'),
            array('820323+2777'),
            array('820323+2778'),
            array('820323+2779')
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($number)
    {
        new PersonalId($number);
    }

    public function interchangeableFormulasProvider()
    {
        return array(
            array('820323-2775', '8203232775'),
            array('19820323-2775', '198203232775'),
            array('19820323-2775', '19820323+2775')
        );
    }

    /**
     * @dataProvider interchangeableFormulasProvider
     */
    public function testInterchangeableFormulas($numberA, $numberB)
    {
        $this->assertSame(
            (string)new PersonalId($numberA),
            (string)new PersonalId($numberB)
        );
    }

    public function testDelimiter()
    {
        $this->assertEquals(
            '820323-2775',
            (new PersonalId('19820323+2775'))->getId()
        );

        $this->assertEquals(
            '820323+2775',
            (new PersonalId('18820323-2775'))->getId()
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            '820323-2775',
            (string) new PersonalId('820323-2775')
        );
    }

    public function testGetSex()
    {
        $personalId = new PersonalId('820323-2775');
        $this->assertEquals(Id::SEX_MALE, $personalId->getSex());
        $this->assertTrue($personalId->isMale());
        $this->assertFalse($personalId->isFemale());
        $this->assertFalse($personalId->isSexUndefined());

        $personalId = new PersonalId('770314-0348');
        $this->assertEquals(Id::SEX_FEMALE, $personalId->getSex());
        $this->assertTrue($personalId->isFemale());
        $this->assertFalse($personalId->isMale());
        $this->assertFalse($personalId->isSexUndefined());
    }

    public function testInvalidDateException()
    {
        $this->setExpectedException('ledgr\id\Exception\InvalidDateStructureException');
        // 001301 is not a valid date
        new PersonalId('001301-0004');
    }

    public function testGetAge()
    {
        $this->assertGreaterThan(
            30,
            (new PersonalId('19820323-2775'))->getAge()
        );
    }

    public function testGetCentury()
    {
        $this->assertEquals(
            '19',
            (new PersonalId('820323-2775'))->getCentury()
        );

        $this->assertEquals(
            '18',
            (new PersonalId('820323+2775'))->getCentury()
        );

        $this->assertEquals(
            '19',
            (new PersonalId('450415-0220'))->getCentury()
        );
    }

    public function testFormat()
    {
        $this->assertEquals(
            '82',
            (new PersonalId('19820323-2775'))->format('y')
        );
    }

    public function testGetLegalForm()
    {
        $personalId = new PersonalId('770314-0348');
        $this->assertEquals(Id::LEGAL_FORM_UNDEFINED, $personalId->getLegalForm());
        $this->assertTrue($personalId->isLegalFormUndefined());
        $this->assertFalse($personalId->isStateOrParish());
        $this->assertFalse($personalId->isIncorporated());
        $this->assertFalse($personalId->isPartnership());
        $this->assertFalse($personalId->isAssociation());
        $this->assertFalse($personalId->isNonProfit());
        $this->assertFalse($personalId->isTradingCompany());
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            Id::COUNTY_KRONOBERG,
            (new PersonalId('820323-2775'))->getBirthCounty()
        );

        $this->assertEquals(
            Id::COUNTY_STOCKHOLM,
            (new PersonalId('19891231-1308'))->getBirthCounty()
        );

        $this->assertEquals(
            Id::COUNTY_UNDEFINED,
            (new PersonalId('19891231-9905'))->getBirthCounty()
        );

        $this->assertEquals(
            Id::COUNTY_UNDEFINED,
            (new PersonalId('19900101-1304'))->getBirthCounty()
        );
    }

    public function testGetBirthCountyTruthiness()
    {
        $this->assertFalse(
            !!(new PersonalId('19891231-9905'))->getBirthCounty(),
            'When birth county is undefined getBirthCounty() should be falsey'
        );

        $this->assertTrue(
            !!(new PersonalId('19891231-1308'))->getBirthCounty(),
            'When birth county is not undefined getBirthCounty() should be truthy'
        );
    }
}
