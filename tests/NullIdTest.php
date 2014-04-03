<?php

namespace ledgr\id;

class NullIdTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCheckDigit()
    {
        $id = new NullId();
        $this->assertEquals('0', $id->getCheckDigit());
    }

    public function testGetDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('-', $id->getDelimiter());
    }

    public function testGetString()
    {
        NullId::setString('foobar');
        $id = new NullId();
        $this->assertEquals('foobar', (string)$id);
        $this->assertEquals('foobar', $id->getId());
    }
}
