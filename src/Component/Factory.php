<?php

namespace byrokrat\id\Component;

use byrokrat\id\IdFactory;
use byrokrat\id\IdInterface;
use byrokrat\id\Exception;

/**
 * Abstract factory implementation
 */
trait Factory
{
    /**
     * @var IdFactory Fallback factory
     */
    private $factory;

    /**
     * Set factory used if this factory fails
     */
    public function __construct(IdFactory $factory = null)
    {
        $this->factory = $factory ?: new IdFactory;
    }

    /**
     * Create ID object from raw id string
     *
     * @param  string $raw Raw id string
     * @return IdInterface
     */
    public function createId($raw)
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
    abstract protected function createNewInstance($raw);
}
