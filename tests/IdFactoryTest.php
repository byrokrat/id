<?php

namespace byrokrat\id;

class IdFactoryTest extends \PHPUnit_Framework_TestCase
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

    public function testDecoration()
    {
        $factory = new OrganizationIdFactory(
            new FakeIdFactory(
                new PersonalIdFactory(
                    new CoordinationIdFactory
                )
            )
        );

        $this->setExpectedException('byrokrat\id\Exception');
        $factory->createId('unvalid id');
    }
}
