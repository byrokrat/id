<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\IdFactoryInterface;
use byrokrat\id\FailingIdFactory;
use byrokrat\id\IdInterface;
use byrokrat\id\Exception;

abstract class AbstractFactoryDecorator implements IdFactoryInterface
{
    /**
     * @var IdFactoryInterface
     */
    private $factory;

    /**
     * Set factory used if this factory fails
     */
    public function __construct(IdFactoryInterface $factory = null)
    {
        $this->factory = $factory ?: new FailingIdFactory();
    }

    public function createId(string $raw): IdInterface
    {
        try {
            return $this->createNewInstance($raw);
        } catch (Exception $e) {
            return $this->factory->createId($raw);
        }
    }

    abstract protected function createNewInstance(string $raw): IdInterface;
}
