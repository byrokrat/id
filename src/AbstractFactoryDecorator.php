<?php

namespace byrokrat\id;

/**
 * Abstract factory decorator
 */
abstract class AbstractFactoryDecorator extends IdFactory
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
        $this->factory = $factory ?: new IdFactory();
    }

    /**
     * Create ID object from raw id string
     *
     * @param  string $raw Raw id string
     * @return IdInterface
     */
    public function createId(string $raw): IdInterface
    {
        try {
            return $this->createNewInstance($raw);
        } catch (Exception $e) {
            return $this->factory->createId($raw);
        }
    }

    /**
     * Instantiate ID object
     *
     * @param  string $raw Raw id string
     * @return IdInterface
     */
    abstract protected function createNewInstance(string $raw): IdInterface;
}
