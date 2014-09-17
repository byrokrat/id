<?php

namespace ledgr\id;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromFormat()
    {
        $datetime = DateTime::createFromFormat('Ymd', '20140880');
        $this->assertEquals(
            '2014',
            $datetime->format('Y')
        );
    }

    public function testCreateFromFormatException()
    {
        $this->setExpectedException('ledgr\id\Exception\InvalidDateStructureException');
        DateTime::createFromFormat('ymd', '14xx80');
    }
}
