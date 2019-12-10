<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\IdInterface;
use byrokrat\id\Exception\InvalidCheckDigitException;

class Modulo10Test extends \PHPUnit\Framework\TestCase
{
    public function invalidProvider(): array
    {
        return [
            ['y'],
            [''],
            ['12.12'],
            ['55555550'],
            ['9912340'],
            ['9876543210'],
            ['49927398710'],
        ];
    }

    /**
     * @dataProvider invalidProvider
     */
    public function testInvalidCheckDigit(string $number): void
    {
        $this->expectException(InvalidCheckDigitException::CLASS);

        $id = $this->prophesize(IdInterface::CLASS);
        @$id->getId()->willReturn($number);

        Modulo10::validateCheckDigit($id->reveal());
    }

    public function validProvider(): array
    {
        return [
            ['55555551'],
            ['9912346'],
            ['9876543217'],
            ['49927398716'],
        ];
    }

    /**
     * @dataProvider validProvider
     */
    public function testValidCheckDigit(string $number): void
    {
        $id = $this->prophesize(IdInterface::CLASS);
        @$id->getId()->willReturn($number);

        $this->assertNull(Modulo10::validateCheckDigit($id->reveal()));
    }
}
