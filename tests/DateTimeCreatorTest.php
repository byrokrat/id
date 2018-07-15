<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Exception\InvalidDateStructureException;
use PHPUnit\Framework\TestCase;

class DateTimeCreatorTest extends TestCase
{
    public function testCreateFromFormat()
    {
        $this->assertEquals(
            '2014',
            DateTimeCreator::createFromFormat('Ymd', '20140880')->format('Y')
        );
    }

    public function testTime()
    {
        $this->assertEquals(
            '00:00:00',
            DateTimeCreator::createFromFormat('Ymd', '20140880')->format('H:i:s')
        );
    }

    public function testCreateFromFormatException()
    {
        $this->expectException(InvalidDateStructureException::class);
        DateTimeCreator::createFromFormat('ymd', '14xx80');
    }
}
