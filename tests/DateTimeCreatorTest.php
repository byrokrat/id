<?php

namespace ledgr\id;

class DateTimeCreatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromFormat()
    {
        $datetime = DateTimeCreator::createFromFormat('Ymd', '20140880');
        $this->assertEquals(
            '2014',
            $datetime->format('Y')
        );
    }

    public function testCreateFromFormatException()
    {
        $this->setExpectedException('ledgr\id\Exception\InvalidDateStructureException');
        DateTimeCreator::createFromFormat('ymd', '14xx80');
    }
}
