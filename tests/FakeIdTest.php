<?php

namespace byrokrat\id;

use PHPUnit\Framework\TestCase;

class FakeIdTest extends TestCase
{
    public function invalidStructureProvider()
    {
        return [
            [''],
            ['123456'],
            ['123456-'],
            ['-1234'],
            ['123456-123'],
            ['123456-12345'],
            ['1234567-1234'],
            ['1234567-1234'],
            ['123456-1A34'],
            ['12A456-1234'],
            ['123456+'],
            ['+1234'],
            ['123456+123'],
            ['123456+12345'],
            ['1234567+1234'],
            ['1234567+1234'],
            ['123456+1A34'],
            ['12A456+1234'],
            ['123456-1234'],
            ['123456+1234'],
            ['820323-2775'],
            ['820323+2775'],
        ];
    }

    /**
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($number)
    {
        $this->expectException(Exception\InvalidStructureException::CLASS);
        new FakeId($number);
    }

    public function interchangeableFormulasProvider()
    {
        return [
            ['820323-xxxx', '820323xxxx'],
            ['19820323-xxxx', '19820323xxxx'],
            ['19820323-xxxx', '19820323+xxxx'],
        ];
    }

    /**
     * @dataProvider interchangeableFormulasProvider
     */
    public function testInterchangeableFormulas($numberA, $numberB)
    {
        $this->assertSame(
            (string)new FakeId($numberA),
            (string)new FakeId($numberB)
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            '820323-xxxx',
            (string) new FakeId('820323-xxxx')
        );
    }

    public function testGetCentry()
    {
        $this->assertEquals(
            '19',
            (new FakeId('820323-xxxx'))->getCentury()
        );

        $this->assertEquals(
            '18',
            (new FakeId('820323+xxxx'))->getCentury()
        );

        $this->assertEquals(
            '18',
            (new FakeId('450415+xxxx'))->getCentury()
        );
    }

    public function testGetDelimiter()
    {
        $this->assertEquals(
            '-',
            (new FakeId('19820323+xx1x'))->getDelimiter()
        );

        $this->assertEquals(
            '+',
            (new FakeId('18820323-xx2x'))->getDelimiter()
        );
    }

    public function testGetSex()
    {
        $fakeId = new FakeId('820323-xx1x');
        $this->assertEquals(Id::SEX_MALE, $fakeId->getSex());
        $this->assertTrue($fakeId->isMale());
        $this->assertFalse($fakeId->isFemale());
        $this->assertFalse($fakeId->isSexUndefined());

        $fakeId = new FakeId('770314-xx2x');
        $this->assertEquals(Id::SEX_FEMALE, $fakeId->getSex());
        $this->assertFalse($fakeId->isMale());
        $this->assertTrue($fakeId->isFemale());
        $this->assertFalse($fakeId->isSexUndefined());

        $fakeId = new FakeId('770314-xxxx');
        $this->assertEquals(Id::SEX_UNDEFINED, $fakeId->getSex());
        $this->assertFalse($fakeId->isMale());
        $this->assertFalse($fakeId->isFemale());
        $this->assertTrue($fakeId->isSexUndefined());
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            Id::COUNTY_UNDEFINED,
            (new FakeId('770314-xxxx'))->getBirthCounty()
        );
    }
}
