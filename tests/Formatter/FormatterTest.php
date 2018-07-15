<?php

declare(strict_types = 1);

namespace byrokrat\id\Formatter;

use byrokrat\id\FakeId;
use byrokrat\id\PersonalId;
use byrokrat\id\OrganizationId;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function testFormat()
    {
        $this->assertEquals(
            '18 820323 + 010 0 F Stockholms stad',
            (new Formatter('C S - s k X B'))->format(new PersonalId('18820323-0100'))
        );
    }

    public function testFormatAge()
    {
        $this->assertGreaterThan(
            100,
            (new Formatter('A'))->format(new FakeId('18820323-xxxx'))
        );
    }

    public function testFormatLegalStatus()
    {
        $this->assertEquals(
            'Ideell förening eller stiftelse',
            (new Formatter('L'))->format(new OrganizationId('835000-0892'))
        );
    }

    public function testFormatDate()
    {
        $this->assertEquals(
            '1982 82 03 3 March Mar 31 12 23 23 Tuesday Tue 2 2 81',
            (new Formatter('Y y m n F M t W d j l D w N z'))->format(new FakeId('820323-xxxx'))
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
