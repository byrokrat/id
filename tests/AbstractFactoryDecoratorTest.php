<?php

namespace byrokrat\id;

use PHPUnit\Framework\TestCase;

class AbstractFactoryDecoratorTest extends TestCase
{
    public function testConstruct()
    {
        $factory = new class extends AbstractFactoryDecorator {
            public function createNewInstance(?string $raw): IdInterface {}
        };

        $this->assertInstanceOf(IdFactory::class, $factory);
    }

    public function testCreateId()
    {
        $factory = new class extends AbstractFactoryDecorator {
            public function createNewInstance(?string $raw): IdInterface {
                return new class extends AbstractId {};
            }
        };

        $this->assertInstanceOf(AbstractId::class, $factory->createId('123'));
    }

    public function testUseNextFactoryIfIdCannotBeCreated()
    {
        $nextFactory = $this->createMock(AbstractFactoryDecorator::class);
        $nextFactory->expects($this->once())->method('createId');

        $factory = new class($nextFactory) extends AbstractFactoryDecorator {
            public function createNewInstance(?string $raw): IdInterface {
                throw new class extends \Exception implements Exception {};
            }
        };

        $factory->createId('123');
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

        $this->expectException(Exception::class);
        $factory->createId('unvalid id');
    }
}
