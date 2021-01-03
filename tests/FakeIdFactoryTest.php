<?php

declare(strict_types=1);

namespace byrokrat\id;

class FakeIdFactoryTest extends \PHPUnit\Framework\TestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    public function testCreateId()
    {
        $this->assertInstanceOf(
            FakeId::CLASS,
            (new FakeIdFactory())->createId('701023-xxxx')
        );
    }

    public function testPassToDecoratedAtFailure()
    {
        $id = $this->createMock(IdInterface::CLASS);

        $decorated = $this->prophesize(IdFactoryInterface::CLASS);
        $decorated->createId('foo', null)->willReturn($id);

        $this->assertSame(
            $id,
            (new FakeIdFactory($decorated->reveal()))->createId('foo')
        );
    }

    public function testDefaultsToExceptionOnFailure()
    {
        $this->expectException(Exception::class);
        (new FakeIdFactory())->createId('unvalid id');
    }
}
