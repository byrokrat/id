<?php

namespace ledgr\id;

class CorporateIdTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException ledgr\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new CorporateId($nr);
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    public function testInvalidCheckDigit($nr)
    {
        new CorporateId($nr);
    }

    /**
     * @dataProvider validProvider
     */
    public function testValidIds($id)
    {
        $id = new CorporateId($id);
        $this->assertTrue(true);
    }

    public function testGetId()
    {
        $id = new CorporateId('702001-7781');
        $this->assertEquals($id->getId(), '702001-7781');
    }

    public function testToString()
    {
        $id = new CorporateId('702001-7781');
        $this->assertEquals((string)$id, '702001-7781');
    }

    public function testGetGroupDescription()
    {
        $id = new CorporateId('232100-0016');
        $this->assertEquals('Stat, landsting, kommun eller församling', $id->getGroupDescription());

        $id = new CorporateId('502017-7753');
        $this->assertEquals('Aktiebolag', $id->getGroupDescription());

        $id = new CorporateId('662011-0541');
        $this->assertEquals('Enkelt bolag', $id->getGroupDescription());

        $id = new CorporateId('702001-7781');
        $this->assertEquals('Ekonomisk förening', $id->getGroupDescription());

        $id = new CorporateId('835000-0892');
        $this->assertEquals('Ideell förening eller stiftelse', $id->getGroupDescription());

        $id = new CorporateId('916452-6197');
        $this->assertEquals('Handelsbolag, kommanditbolag eller enkelt bolag', $id->getGroupDescription());

        $id = new CorporateId('132100-0018');
        $this->assertEquals('Okänd', $id->getGroupDescription());
    }

    public function testSex()
    {
        $id = new CorporateId('132100-0018');
        $this->assertEquals(Id::SEX_UNDEFINED, $id->getSex());
        $this->assertFalse($id->isMale());
        $this->assertFalse($id->isFemale());
        $this->assertTrue($id->isSexUndefined());
    }
}
