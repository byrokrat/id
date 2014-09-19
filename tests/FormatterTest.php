<?php

namespace ledgr\id;

class FormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $this->assertEquals(
            '18820323+xxxx',
            (new Formatter('CS-sk'))->format(new FakeId('18820323-xxxx'))
        );
    }

    public function testFormatDate()
    {
        $this->assertEquals(
            '82/03/23',
            (new Formatter('y/m/d'))->format(new FakeId('820323-xxxx'))
        );
    }

    public function testEscape()
    {
        $this->assertEquals(
            'Ymd\\',
            (new Formatter('\Y\m\d\\\\'))->format(new FakeId('820323-xxxx'))
        );
    }
}
