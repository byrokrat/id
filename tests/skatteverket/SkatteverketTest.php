<?php

declare(strict_types=1);

namespace byrokrat\id\skatteverket;

use byrokrat\id\CoordinationId;
use byrokrat\id\CoordinationIdFactory;
use byrokrat\id\IdFactoryInterface;
use byrokrat\id\PersonalId;
use byrokrat\id\PersonalIdFactory;
use PHPUnit\Framework\TestCase;

class SkatteverketTest extends TestCase
{
    /**
     * @var IdFactoryInterface
     */
    private static $factory;

    public static function setUpBeforeClass(): void
    {
        self::$factory = new PersonalIdFactory(new CoordinationIdFactory());
    }

    public function personalProvider(): iterable
    {
        return new TestdataProvider(__DIR__ . '/testdata/personal');
    }

    /**
     * @dataProvider personalProvider
     */
    public function testPersonalIds(string $number): void
    {
        $this->assertInstanceOf(
            PersonalId::class,
            self::$factory->createId($number)
        );
    }

    public function coordinationProvider(): iterable
    {
        return new TestdataProvider(__DIR__ . '/testdata/coordination');
    }

    /**
     * @dataProvider coordinationProvider
     */
    public function testCoordinationIds(string $number): void
    {
        $this->assertInstanceOf(
            CoordinationId::class,
            self::$factory->createId($number)
        );
    }
}
