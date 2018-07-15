<?php

declare(strict_types = 1);

namespace byrokrat\id;

use PHPUnit\Framework\TestCase;

class NullIdTest extends TestCase
{
    public function testGetSerialPreDelimiter()
    {
        $this->assertEquals(
            '000000',
            (new NullId)->getSerialPreDelimiter()
        );
    }

    public function testGetSerialPostDelimiter()
    {
        $this->assertEquals(
            '000',
            (new NullId)->getSerialPostDelimiter()
        );
    }

    public function testGetCheckDigit()
    {
        $this->assertEquals(
            '0',
            (new NullId)->getCheckDigit()
        );
    }

    public function testGetDelimiter()
    {
        $this->assertEquals(
            '-',
            (new NullId)->getDelimiter()
        );
    }

    public function testGetString()
    {
        NullId::setString('foobar');

        $this->assertEquals(
            'foobar',
            (string) new NullId
        );

        $this->assertEquals(
            'foobar',
            (new NullId)->getId()
        );
    }

    public function testGetBirthDate()
    {
        $this->expectException('byrokrat\id\Exception\DateNotSupportedException');
        (new NullId)->getBirthDate();
    }

    public function testGetSex()
    {
        $nullId = new NullId();
        $this->assertEquals(IdInterface::SEX_UNDEFINED, $nullId->getSex());
        $this->assertTrue($nullId->isSexUndefined());
        $this->assertFalse($nullId->isMale());
        $this->assertFalse($nullId->isFemale());
    }

    public function testGetLegalForm()
    {
        $nullId = new NullId();
        $this->assertEquals(IdInterface::LEGAL_FORM_UNDEFINED, $nullId->getLegalForm());
        $this->assertTrue($nullId->isLegalFormUndefined());
        $this->assertFalse($nullId->isStateOrParish());
        $this->assertFalse($nullId->isIncorporated());
        $this->assertFalse($nullId->isPartnership());
        $this->assertFalse($nullId->isAssociation());
        $this->assertFalse($nullId->isNonProfit());
        $this->assertFalse($nullId->isTradingCompany());
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            IdInterface::COUNTY_UNDEFINED,
            (new NullId)->getBirthCounty()
        );
    }
}
