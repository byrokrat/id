<?php

declare(strict_types = 1);

namespace byrokrat\id;

class PersonalIdFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateId()
    {
        $this->assertInstanceOf(
            PersonalId::CLASS,
            (new PersonalIdFactory)->createId('820323-2775')
        );
    }

    public function testPassToDecoratedAtFailure()
    {
        $id = @$this->createMock(IdInterface::CLASS);

        $decorated = $this->prophesize(IdFactoryInterface::CLASS);
        @$decorated->createId('foo')->willReturn($id);

        $this->assertSame(
            $id,
            (new PersonalIdFactory($decorated->reveal()))->createId('foo')
        );
    }

    public function testDefaultsToExceptionOnFailure()
    {
        $this->expectException(Exception::class);
        (new PersonalIdFactory)->createId('unvalid id');
    }
}
