<?php

declare(strict_types = 1);

namespace byrokrat\id;

class OrganizationIdFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateId()
    {
        $this->assertInstanceOf(
            OrganizationId::CLASS,
            (new OrganizationIdFactory)->createId('702001-7781')
        );
    }

    public function testPassToDecoratedAtFailure()
    {
        $id = @$this->createMock(IdInterface::CLASS);

        $decorated = $this->prophesize(IdFactoryInterface::CLASS);
        @$decorated->createId('foo')->willReturn($id);

        $this->assertSame(
            $id,
            (new OrganizationIdFactory($decorated->reveal()))->createId('foo')
        );
    }

    public function testDefaultsToExceptionOnFailure()
    {
        $this->expectException(Exception::class);
        (new OrganizationIdFactory)->createId('unvalid id');
    }
}
