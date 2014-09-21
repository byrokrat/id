<?php

namespace ledgr\id;

class IdFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testPersonalIdFactory()
    {
        $factory = new PersonalIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\PersonalId',
            $factory->create('820323-2775')
        );
    }

    public function testCoordinationIdFactory()
    {
        $factory = new CoordinationIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\CoordinationId',
            $factory->create('701063-2391')
        );
    }

    public function testOrganizationIdFactory()
    {
        $factory = new OrganizationIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\OrganizationId',
            $factory->create('702001-7781')
        );
    }

    public function testFakeIdFactory()
    {
        $factory = new FakeIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\FakeId',
            $factory->create('701023-xxxx')
        );
    }

    public function testNullIdFactory()
    {
        $factory = new NullIdFactory();
        $this->assertInstanceOf(
            '\ledgr\id\NullId',
            $factory->create('')
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

        $this->setExpectedException('ledgr\id\Exception');
        $factory->create('unvalid id');
    }
}
