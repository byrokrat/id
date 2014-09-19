<?php

namespace ledgr\id;

class NullIdTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSerialPreDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('000000', $id->getSerialPreDelimiter());
    }

    public function testGetSerialPostDelimiter()
    {
        $id = new NullId();
        $this->assertEquals('000', $id->getSerialPostDelimiter());
    }

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

    public function testGetDate()
    {
        $this->setExpectedException('ledgr\id\Exception\DateNotSupportedException');
        (new NullId)->getDate();
    }
}
