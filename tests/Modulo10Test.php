<?php

declare(strict_types = 1);

namespace byrokrat\id;

use PHPUnit\Framework\TestCase;

class Modulo10Test extends TestCase
{
    public function invalidStructureProvider()
    {
        return [
            ['y'],
            [''],
            ['12.12']
        ];
    }

    /**
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructureIsValid($number)
    {
        $this->expectException(Exception\InvalidStructureException::CLASS);
        Modulo10::isValid($number);
    }

    /**
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructureCalculateCheckDigit($number)
    {
        $this->expectException(Exception\InvalidStructureException::CLASS);
        Modulo10::calculateCheckDigit($number);
    }

    public function testIsValid()
    {
        $this->assertTrue(Modulo10::isValid('55555551'));
        $this->assertTrue(Modulo10::isValid('9912346'));
        $this->assertTrue(Modulo10::isValid('9876543217'));
        $this->assertTrue(Modulo10::isValid('49927398716'));
        $this->assertFalse(Modulo10::isValid('55555550'));
        $this->assertFalse(Modulo10::isValid('9912340'));
        $this->assertFalse(Modulo10::isValid('9876543210'));
        $this->assertFalse(Modulo10::isValid('49927398710'));
    }

    public function testCalculateCheckDigit()
    {
        $this->assertSame('1', Modulo10::calculateCheckDigit('5555555'));
        $this->assertSame('6', Modulo10::calculateCheckDigit('991234'));
        $this->assertSame('7', Modulo10::calculateCheckDigit('987654321'));
        $this->assertSame('6', Modulo10::calculateCheckDigit('4992739871'));
    }
}
