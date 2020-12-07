<?php

declare(strict_types = 1);

namespace byrokrat\id;

class CoordinationIdFactoryTest extends \PHPUnit\Framework\TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    public function testCreateId()
    {
        $this->assertInstanceOf(
            CoordinationId::CLASS,
            (new CoordinationIdFactory)->createId('701063-2391')
        );
    }

    public function testPassToDecoratedAtFailure()
    {
        $id = $this->createMock(IdInterface::CLASS);

        $decorated = $this->prophesize(IdFactoryInterface::CLASS);
        $decorated->createId('foo', null)->willReturn($id);

        $this->assertSame(
            $id,
            (new CoordinationIdFactory($decorated->reveal()))->createId('foo')
        );
    }

    public function testDefaultsToExceptionOnFailure()
    {
        $this->expectException(Exception::class);
        (new CoordinationIdFactory)->createId('unvalid id');
    }
}
