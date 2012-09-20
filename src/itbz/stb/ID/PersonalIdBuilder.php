<?php
/**
 * This file is part of the STB package
 *
 * Copyright (c) 2012 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 *
 * @package STB\ID
 */
namespace itbz\STB\ID;
use itbz\STB\Exception\InvalidStructureException;
use itbz\STB\Exception\InvalidCheckDigitException;


/**
 * Build personal ids
 *
 * @package STB\ID
 */
class PersonalIdBuilder
{

    /**
     * Flag if fake id is allowed
     *
     * @var bool
     */
    private $_bUseFake = FALSE;


    /**
     * Flag if coordination id is allowed
     *
     * @var bool
     */
    private $_bUseCoord = TRUE;


    /**
     * Unprocessed id
     *
     * @var string
     */
    private $_rawId = '';


    /**
     * Set unproccessed id
     *
     * @param string $rawId
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function setId($rawId)
    {
        assert('is_string($rawId)');
        $this->_rawId = $rawId;

        return $this;
    }


    /**
     * Enable fake id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function enableFakeId()
    {
        $this->_bUseFake = TRUE;
        
        return $this;
    }


    /**
     * Disable fake id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function disableFakeId()
    {
        $this->_bUseFake = FALSE;

        return $this;
    }


    /**
     * Enable coordination id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function enableCoordinationId()
    {
        $this->_bUseCoord = TRUE;

        return $this;
    }


    /**
     * Disable coordination id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function disableCoordinationId()
    {
        $this->_bUseCoord = FALSE;

        return $this;
    }


    /**
     * Get personal id
     *
     * Creates PersonalId, CoordinationId or FakeId depending on raw id and
     * builder settings. PersonalId takes precedence over CoordinationId and
     * CoordinationId takes precedence over FakeId.
     *
     * @return PersonalId
     *
     * @throws InvalidStructureException if structure is invalid
     *
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function getId()
    {
        // Create PersonalId
        try {

            return new PersonalId($this->_rawId);

        } catch (InvalidStructureException $e) {
            // Throw exception if coord and fake are disabled
            if (!$this->_bUseCoord && !$this->_bUseFake) {
                throw $e;
            }
        }

        // Create CoordinationId
        if ($this->_bUseCoord) {
            try {

                return new CoordinationId($this->_rawId);
            } catch (InvalidStructureException $e) {
                // Throw exception if fake is disabled
                if (!$this->_bUseFake) {
                    throw $e;
                }
            }
        }
        
        // Create FakeId
        return new FakeId($this->_rawId);
    }

}
