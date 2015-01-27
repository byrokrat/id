<?php

namespace byrokrat\id\Component;

use byrokrat\id\IdFactory;
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
     *
     * @param IdFactory $factory
     */
    public function __construct(IdFactory $factory = null)
    {
        $this->factory = $factory ?: new IdFactory;
    }

    /**
     * Create ID object from raw id string
     *
     * @param  string $rawId Raw id string
     * @return \byrokrat\id\Id
     */
    public function create($rawId)
    {
        try {
            return $this->createNewInstance($rawId);
        } catch (Exception $e) {
            return $this->factory->create($rawId);
        }
    }

    /**
     * Instantiate ID object
     *
     * @param  string $rawId Raw id string
     * @return \byrokrat\id\Id
     */
    abstract protected function createNewInstance($rawId);
}
