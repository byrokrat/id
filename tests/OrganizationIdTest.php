<?php

namespace ledgr\id;

class OrganizationIdTest extends \PHPUnit_Framework_TestCase
{
    public function invalidStructureProvider()
    {
        return array(
            array('123456'),
            array('123456+1234'),
            array('123456-123'),
            array('123456-12345'),
            array('12345-1234'),
            array('1234567-1234'),
            array('A23456-1234'),
            array('123456-A234'),
            array('111111-1234'),
            array('')
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($number)
    {
        new OrganizationId($number);
    }

    public function invalidCheckDigitProvider()
    {
        return array(
            array('502017-7750'),
            array('556097-8600'),
            array('556086-8220'),
            array('556432-4320'),
            array('556619-3050'),
            array('556337-2190'),
            array('556601-6900'),
            array('556758-1780'),
            array('232100-0010'),
            array('202100-5480'),
            array('835000-0890'),
            array('702001-7780'),
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($number)
    {
        new OrganizationId($number);
    }

    public function validProvider()
    {
        return array(
            array('502017-7753'),
            array('556097-8602'),
            array('556086-8225'),
            array('556432-4324'),
            array('556619-3057'),
            array('556337-2191'),
            array('556601-6902'),
            array('556758-1789'),
            array('232100-0016'),
            array('202100-5489'),
            array('835000-0892'),
            array('702001-7781'),
        );
    }

    /**
     * @dataProvider validProvider
     */
    public function testValidIds($number)
    {
        new OrganizationId($number);
        $this->assertTrue(true);
    }

    public function testInterchangeableFormulas()
    {
        $this->assertEquals(
            (string) new OrganizationId('502017-7753'),
            (string) new OrganizationId('5020177753')
        );
    }

    public function testGetId()
    {
        $this->assertEquals(
            '702001-7781',
            (new OrganizationId('702001-7781'))->getId()
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            '702001-7781',
            (string) new OrganizationId('702001-7781')
        );
    }

    public function testGetDate()
    {
        $this->setExpectedException('ledgr\id\Exception\DateNotSupportedException');
        (new OrganizationId('132100-0018'))->getDate();
    }

    public function testGetSex()
    {
        $organizationId = new OrganizationId('132100-0018');
        $this->assertEquals(Id::SEX_UNDEFINED, $organizationId->getSex());
        $this->assertFalse($organizationId->isMale());
        $this->assertFalse($organizationId->isFemale());
        $this->assertTrue($organizationId->isSexUndefined());
    }

    public function testGetLegalForm()
    {
        $organizationId = new OrganizationId('232100-0016');
        $this->assertEquals(Id::LEGAL_FORM_STATE_PARISH, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isStateOrParish());

        $organizationId = new OrganizationId('502017-7753');
        $this->assertEquals(Id::LEGAL_FORM_INCORPORATED, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isIncorporated());

        $organizationId = new OrganizationId('662011-0541');
        $this->assertEquals(Id::LEGAL_FORM_PARTNERSHIP, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isPartnership());

        $organizationId = new OrganizationId('702001-7781');
        $this->assertEquals(Id::LEGAL_FORM_ASSOCIATION, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isAssociation());

        $organizationId = new OrganizationId('835000-0892');
        $this->assertEquals(Id::LEGAL_FORM_NONPROFIT, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isNonProfit());

        $organizationId = new OrganizationId('916452-6197');
        $this->assertEquals(Id::LEGAL_FORM_TRADING, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isTradingCompany());

        $organizationId = new OrganizationId('132100-0018');
        $this->assertEquals(Id::LEGAL_FORM_UNDEFINED, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isLegalFormUndefined());
    }

    public function testGetLegalFormTruthiness()
    {
        $this->assertFalse(
            !!(new OrganizationId('132100-0018'))->getLegalForm(),
            'When legal form is undefined getLegalForm() should be falsey'
        );

        $this->assertTrue(
            !!(new OrganizationId('232100-0016'))->getLegalForm(),
            'When legal form is not undefined getLegalForm() should be truthy'
        );
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            Id::COUNTY_UNDEFINED,
            (new OrganizationId('702001-7781'))->getBirthCounty()
        );
    }
}
