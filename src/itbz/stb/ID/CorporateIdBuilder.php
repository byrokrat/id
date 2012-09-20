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
 * Build corporate ids
 *
 * @package STB\ID
 */
class CorporateIdBuilder
{

    /**
     * Flag if personal id is allowed
     *
     * @var bool
     */
    private $_bUsePersonal = TRUE;


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
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function setId($rawId)
    {
        assert('is_string($rawId)');
        $this->_rawId = $rawId;

        return $this;
    }


    /**
     * Enable personal id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function enablePersonalId()
    {
        $this->_bUsePersonal = TRUE;
        
        return $this;
    }


    /**
     * Disable personal id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function disablePersonalId()
    {
        $this->_bUsePersonal = FALSE;

        return $this;
    }


    /**
     * Enable coordination id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function enableCoordinationId()
    {
        $this->_bUseCoord = TRUE;

        return $this;
    }


    /**
     * Disable coordination id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function disableCoordinationId()
    {
        $this->_bUseCoord = FALSE;

        return $this;
    }


    /**
     * Get corporate id
     *
     * Creates CorporateId, PersonalId or CoordinationId depending on raw id and
     * builder settings. CorporateId takes precedence over PersonalId and
     * PersonalId takes precedence over CoordinationId
     *
     * @return CorporateId|PersonalId|CoordinationId
     *
     * @throws InvalidStructureException if structure is invalid
     *
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function getId()
    {
        // Create CorporateId
        try {

            return new CorporateId($this->_rawId);

        } catch (InvalidStructureException $e) {
            // Throw exception if coord and personal id are disabled
            if (!$this->_bUseCoord && !$this->_bUsePersonal) {
                throw $e;
            }
        }

        // Create PersonalId
        if ($this->_bUsePersonal) {
            try {

                return new PersonalId($this->_rawId);
            } catch (InvalidStructureException $e) {
                // Throw exception if coordination is disabled
                if (!$this->_bUseCoord) {
                    throw $e;
                }
            }
        }
        
        // Create CoordinationId
        return new CoordinationId($this->_rawId);
    }

}
