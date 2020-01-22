<?php

declare(strict_types = 1);

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

    public function sexProvider(): array
    {
        return [
            ['770314-xxFx', Sexes::SEX_FEMALE],
            ['770314-xxfx', Sexes::SEX_FEMALE],
            ['770314-xx2x', Sexes::SEX_FEMALE],
            ['770314-xx4x', Sexes::SEX_FEMALE],
            ['770314-xxMx', Sexes::SEX_MALE],
            ['770314-xxmx', Sexes::SEX_MALE],
            ['770314-xx1x', Sexes::SEX_MALE],
            ['770314-xx3x', Sexes::SEX_MALE],
            ['770314-xxOx', Sexes::SEX_OTHER],
            ['770314-xxox', Sexes::SEX_OTHER],
            ['770314-xxXx', Sexes::SEX_UNDEFINED],
            ['770314-xxxx', Sexes::SEX_UNDEFINED],
        ];
    }

    /**
     * @dataProvider sexProvider
     */
    public function testGetSex(string $raw, string $expextedSex): void
    {
        $this->assertEquals(
            $expextedSex,
            (new FakeId($raw))->getSex()
        );
    }

    public function testSexInspectorMethods()
    {
        $fakeId = new FakeId('820323-xx1x');
        $this->assertTrue($fakeId->isMale());
        $this->assertFalse($fakeId->isFemale());
        $this->assertFalse($fakeId->isSexOther());
        $this->assertFalse($fakeId->isSexUndefined());

        $fakeId = new FakeId('770314-xx2x');
        $this->assertFalse($fakeId->isMale());
        $this->assertTrue($fakeId->isFemale());
        $this->assertFalse($fakeId->isSexOther());
        $this->assertFalse($fakeId->isSexUndefined());

        $fakeId = new FakeId('770314-xxxx');
        $this->assertFalse($fakeId->isMale());
        $this->assertFalse($fakeId->isFemale());
        $this->assertFalse($fakeId->isSexOther());
        $this->assertTrue($fakeId->isSexUndefined());

        $fakeId = new FakeId('770314-xxOx');
        $this->assertFalse($fakeId->isMale());
        $this->assertFalse($fakeId->isFemale());
        $this->assertTrue($fakeId->isSexOther());
        $this->assertFalse($fakeId->isSexUndefined());
    }

    public function testGetBirthCounty()
    {
        $this->assertEquals(
            Counties::COUNTY_UNDEFINED,
            (new FakeId('770314-xxxx'))->getBirthCounty()
        );
    }

    public function testComputeCenturyFromCurrentDate()
    {
        $this->assertSame(
            '1910',
            (new FakeId('101010xxxx', new \DateTime('19900101')))->format('Y')
        );
    }
}
