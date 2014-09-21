<?php

namespace ledgr\id;

class NullIdTest extends \PHPUnit_Framework_TestCase
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

    public function testGetDate()
    {
        $this->setExpectedException('ledgr\id\Exception\DateNotSupportedException');
        (new NullId)->getDate();
    }

    public function testGetSex()
    {
        $id = new NullId();
        $this->assertEquals(Id::SEX_UNDEFINED, $id->getSex());
        $this->assertTrue($id->isSexUndefined());
        $this->assertFalse($id->isMale());
        $this->assertFalse($id->isFemale());
    }

    public function testGetLegalForm()
    {
        $id = new NullId();
        $this->assertEquals(Id::LEGAL_FORM_UNDEFINED, $id->getLegalForm());
        $this->assertTrue($id->isLegalFormUndefined());
        $this->assertFalse($id->isStateOrCounty());
        $this->assertFalse($id->isIncorporated());
        $this->assertFalse($id->isPartnership());
        $this->assertFalse($id->isAssociation());
        $this->assertFalse($id->isNonProfit());
        $this->assertFalse($id->isTradingCompany());
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            Id::COUNTY_UNDEFINED,
            (new NullId)->getBirthCounty()
        );
    }
}
