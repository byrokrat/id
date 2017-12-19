<?php

namespace byrokrat\id;

class DateTimeCreatorTest extends \PHPUnit_Framework_TestCase
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
        $this->setExpectedException('byrokrat\id\Exception\InvalidDateStructureException');
        DateTimeCreator::createFromFormat('ymd', '14xx80');
    }
}
