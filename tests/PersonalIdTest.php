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
    public function testInvalidStructure($nr)
    {
        new PersonalId($nr);
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
            array('820323+2779'),
            array('123456-1234'),
            array('123456+1234'),
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($nr)
    {
        new PersonalId($nr);
    }

    public function interchangeableFormulasProvider()
    {
        return array(
            array(new PersonalId('820323-2775'), new PersonalId('8203232775')),
            array(new PersonalId('19820323-2775'), new PersonalId('198203232775')),
            array(new PersonalId('19820323-2775'), new PersonalId('19820323+2775'))
        );
    }

    /**
     * @dataProvider interchangeableFormulasProvider
     */
    public function testInterchangeableFormulas($a, $b)
    {
        $this->assertEquals($a, $b);
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
        $id = new PersonalId('820323-2775');
        $this->assertEquals(Id::SEX_MALE, $id->getSex());
        $this->assertTrue($id->isMale());
        $this->assertFalse($id->isFemale());
        $this->assertFalse($id->isSexUndefined());

        $id = new PersonalId('770314-0348');
        $this->assertEquals(Id::SEX_FEMALE, $id->getSex());
        $this->assertTrue($id->isFemale());
        $this->assertFalse($id->isMale());
        $this->assertFalse($id->isSexUndefined());
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
        $id = new PersonalId('770314-0348');
        $this->assertEquals(Id::LEGAL_FORM_UNDEFINED, $id->getLegalForm());
        $this->assertTrue($id->isLegalFormUndefined());
        $this->assertFalse($id->isStateOrCounty());
        $this->assertFalse($id->isIncorporated());
        $this->assertFalse($id->isPartnership());
        $this->assertFalse($id->isAssociation());
        $this->assertFalse($id->isNonProfit());
        $this->assertFalse($id->isTradingCompany());
    }
}
