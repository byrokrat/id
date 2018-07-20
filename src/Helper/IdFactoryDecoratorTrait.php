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

    public function createId(string $raw): IdInterface
    {
        try {
            return $this->createNewInstance($raw);
        } catch (Exception $e) {
            return $this->decoratedFactory->createId($raw);
        }
    }

    abstract protected function createNewInstance(string $raw): IdInterface;
}
