<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\Exception\InvalidStructureException;

class NumberParserTest extends \PHPUnit\Framework\TestCase
{
    public function testInvalidString(): void
    {
        $this->expectException(InvalidStructureException::CLASS);
        NumberParser::parse('/\d/', 'not-a-digit');
    }

    public function testValidString(): void
    {
        $this->assertEquals(
            ['12', '1', '2'],
            NumberParser::parse('/(\d)(\d)/', '12')
        );
    }
}
