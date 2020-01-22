<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\IdFactoryInterface;
use byrokrat\id\FailingIdFactory;
use byrokrat\id\IdInterface;
use byrokrat\id\Exception;

/**
 * Implements a factory decorator that pass on object creation to decorated factory on failure
 */
trait IdFactoryDecoratorTrait
{
    /**
     * @var IdFactoryInterface
     */
    private $decoratedFactory;

    public function __construct(IdFactoryInterface $decoratedFactory = null)
    {
        $this->decoratedFactory = $decoratedFactory ?: new FailingIdFactory;
    }

    public function createId(string $raw, \DateTimeInterface $atDate = null): IdInterface
    {
        try {
            return $this->createNewInstance($raw, $atDate);
        } catch (Exception $e) {
            return $this->decoratedFactory->createId($raw, $atDate);
        }
    }

    abstract protected function createNewInstance(string $raw, \DateTimeInterface $atDate = null): IdInterface;
}
