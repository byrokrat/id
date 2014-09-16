<?php

namespace ledgr\id;

class FakeIdTest extends \PHPUnit_Framework_TestCase
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

            array('123456-1234'),
            array('123456+1234'),
            array('820323-2775'),
            array('820323+2775'),
        );
    }

    /**
     * @expectedException ledgr\id\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new FakeId($nr);
    }

    public function testCentry()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('1982', $id->getDate()->format('Y'));

        $id = new FakeId('820323+xxxx');
        $this->assertEquals('1882', $id->getDate()->format('Y'));

        $id = new FakeId('450415+xxxx');
        $this->assertEquals('1845', $id->getDate()->format('Y'));
    }

    public function testDelimiter()
    {
        $id = new FakeId('19820323+xx1x');
        $this->assertEquals('820323-xx1x', $id->getId());

        $id = new FakeId('18820323-xx2x');
        $this->assertEquals('820323+xx2x', $id->getId());
    }

    public function testSex()
    {
        $id = new FakeId('820323-xx1x');
        $this->assertEquals(Id::SEX_MALE, $id->getSex());
        $this->assertTrue($id->isMale());
        $this->assertFalse($id->isFemale());
        $this->assertFalse($id->isSexUndefined());

        $id = new FakeId('770314-xx2x');
        $this->assertEquals(Id::SEX_FEMALE, $id->getSex());
        $this->assertFalse($id->isMale());
        $this->assertTrue($id->isFemale());
        $this->assertFalse($id->isSexUndefined());

        $id = new FakeId('770314-xxxx');
        $this->assertEquals(Id::SEX_UNDEFINED, $id->getSex());
        $this->assertFalse($id->isMale());
        $this->assertFalse($id->isFemale());
        $this->assertTrue($id->isSexUndefined());
    }

    public function testDOB()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('1982-03-23', $id->getDOB());
    }

    public function testToString()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('820323-xxxx', (string)$id);
    }
}
