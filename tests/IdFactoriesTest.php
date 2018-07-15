<?php

declare(strict_types = 1);

namespace byrokrat\id;

use PHPUnit\Framework\TestCase;

class IdFactoriesTest extends TestCase
{
    public function testPersonalIdFactory()
    {
        $this->assertInstanceOf(
            PersonalId::CLASS,
            (new PersonalIdFactory)->createId('820323-2775')
        );
    }

    public function testCoordinationIdFactory()
    {
        $this->assertInstanceOf(
            CoordinationId::CLASS,
            (new CoordinationIdFactory)->createId('701063-2391')
        );
    }

    public function testOrganizationIdFactory()
    {
        $this->assertInstanceOf(
            OrganizationId::CLASS,
            (new OrganizationIdFactory)->createId('702001-7781')
        );
    }

    public function testFakeIdFactory()
    {
        $this->assertInstanceOf(
            FakeId::CLASS,
            (new FakeIdFactory)->createId('701023-xxxx')
        );
    }

    public function testNullIdFactory()
    {
        $this->assertInstanceOf(
            NullId::CLASS,
            (new NullIdFactory)->createId('')
        );
    }

    public function testFailingIdFactory()
    {
        $this->expectException(Exception\UnableToCreateIdException::CLASS);
        (new FailingIdFactory)->createId('');
    }
}
