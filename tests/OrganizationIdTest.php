<?php

declare(strict_types=1);

namespace byrokrat\id;

use PHPUnit\Framework\TestCase;

class OrganizationIdTest extends TestCase
{
    public function invalidStructureProvider()
    {
        return [
            ['123456'],
            ['123456+1234'],
            ['123456-123'],
            ['123456-12345'],
            ['12345-1234'],
            ['1234567-1234'],
            ['A23456-1234'],
            ['123456-A234'],
            ['111111-1234'],
            [''],
        ];
    }

    /**
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($number)
    {
        $this->expectException(Exception\InvalidStructureException::CLASS);
        new OrganizationId($number);
    }

    public function invalidCheckDigitProvider()
    {
        return [
            ['502017-7750'],
            ['556097-8600'],
            ['556086-8220'],
            ['556432-4320'],
            ['556619-3050'],
            ['556337-2190'],
            ['556601-6900'],
            ['556758-1780'],
            ['232100-0010'],
            ['202100-5480'],
            ['835000-0890'],
            ['702001-7780'],
        ];
    }

    /**
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($number)
    {
        $this->expectException(Exception\InvalidCheckDigitException::CLASS);
        new OrganizationId($number);
    }

    public function validProvider()
    {
        return [
            ['502017-7753'],
            ['556097-8602'],
            ['556086-8225'],
            ['556432-4324'],
            ['556619-3057'],
            ['556337-2191'],
            ['556601-6902'],
            ['556758-1789'],
            ['232100-0016'],
            ['202100-5489'],
            ['835000-0892'],
            ['702001-7781'],
        ];
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
            (new OrganizationId('7020017781'))->getId()
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            '702001-7781',
            (string) new OrganizationId('702001-7781')
        );
    }

    public function testGetBirthDate()
    {
        $this->expectException('byrokrat\id\Exception\DateNotSupportedException');
        (new OrganizationId('132100-0018'))->getBirthDate();
    }

    public function testGetSex()
    {
        $organizationId = new OrganizationId('132100-0018');
        $this->assertEquals(Sexes::SEX_UNDEFINED, $organizationId->getSex());
        $this->assertFalse($organizationId->isMale());
        $this->assertFalse($organizationId->isFemale());
        $this->assertTrue($organizationId->isSexUndefined());
    }

    public function testGetLegalForm()
    {
        $organizationId = new OrganizationId('232100-0016');
        $this->assertEquals(LegalForms::LEGAL_FORM_STATE_PARISH, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isStateOrParish());

        $organizationId = new OrganizationId('502017-7753');
        $this->assertEquals(LegalForms::LEGAL_FORM_INCORPORATED, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isIncorporated());

        $organizationId = new OrganizationId('662011-0541');
        $this->assertEquals(LegalForms::LEGAL_FORM_PARTNERSHIP, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isPartnership());

        $organizationId = new OrganizationId('702001-7781');
        $this->assertEquals(LegalForms::LEGAL_FORM_ASSOCIATION, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isAssociation());

        $organizationId = new OrganizationId('835000-0892');
        $this->assertEquals(LegalForms::LEGAL_FORM_NONPROFIT, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isNonProfit());

        $organizationId = new OrganizationId('916452-6197');
        $this->assertEquals(LegalForms::LEGAL_FORM_TRADING, $organizationId->getLegalForm());
        $this->assertTrue($organizationId->isTradingCompany());

        $organizationId = new OrganizationId('132100-0018');
        $this->assertEquals(LegalForms::LEGAL_FORM_UNDEFINED, $organizationId->getLegalForm());
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
            Counties::COUNTY_UNDEFINED,
            (new OrganizationId('702001-7781'))->getBirthCounty()
        );
    }

    public function test12DigitFormat()
    {
        $this->assertSame(
            '007020017781',
            (new OrganizationId('702001-7781'))->format(OrganizationId::FORMAT_12_DIGITS)
        );
    }

    public function testParse12DigitFormat()
    {
        $this->assertSame(
            '702001-7781',
            (new OrganizationId('007020017781'))->format(OrganizationId::FORMAT_10_DIGITS)
        );
    }
}
