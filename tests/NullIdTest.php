<?php

namespace ledgr\id;

class NullIdTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSerialPreDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('000000', $id->getSerialPreDelimiter());
    }

    public function testGetSerialPostDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('000', $id->getSerialPostDelimiter());
    }

    public function testGetCheckDigit()
    {
        $id = new NullId();
        $this->assertEquals('0', $id->getCheckDigit());
    }

    public function testGetDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('-', $id->getDelimiter());
    }

    public function testGetString()
    {
        NullId::setString('foobar');
        $id = new NullId();
        $this->assertEquals('foobar', (string)$id);
        $this->assertEquals('foobar', $id->getId());
    }

    public function testGetDate()
    {
        $this->setExpectedException('ledgr\id\Exception\DateNotSupportedException');
        (new NullId)->getDate();
    }

    public function testGetSex()
    {
        $id = new NullId();
        $this->assertTrue($id->isSexUndefined());
        $this->assertEquals(Id::SEX_UNDEFINED, $id->getSex());
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
}
