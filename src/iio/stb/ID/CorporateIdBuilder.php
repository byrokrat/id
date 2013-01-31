<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb\ID
 */

namespace iio\stb\ID;

use iio\stb\Exception\InvalidStructureException;
use iio\stb\Exception\InvalidCheckDigitException;

/**
 * Build corporate ids
 *
 * @package stb\ID
 */
class CorporateIdBuilder
{
    /**
     * Flag if personal id is allowed
     *
     * @var bool
     */
    private $bUsePersonal = true;

    /**
     * Flag if coordination id is allowed
     *
     * @var bool
     */
    private $bUseCoord = true;

    /**
     * Unprocessed id
     *
     * @var string
     */
    private $rawId = '';

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
        $this->rawId = $rawId;

        return $this;
    }

    /**
     * Enable personal id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function enablePersonalId()
    {
        $this->bUsePersonal = true;

        return $this;
    }

    /**
     * Disable personal id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function disablePersonalId()
    {
        $this->bUsePersonal = false;

        return $this;
    }

    /**
     * Enable coordination id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function enableCoordinationId()
    {
        $this->bUseCoord = true;

        return $this;
    }

    /**
     * Disable coordination id
     *
     * @return CorporateIdBuilder Returns instance to enable chaining
     */
    public function disableCoordinationId()
    {
        $this->bUseCoord = false;

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
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function getId()
    {
        // Create CorporateId
        try {

            return new CorporateId($this->rawId);

        } catch (InvalidStructureException $e) {
            // Throw exception if coord and personal id are disabled
            if (!$this->bUseCoord && !$this->bUsePersonal) {
                throw $e;
            }
        }

        // Create PersonalId
        if ($this->bUsePersonal) {
            try {

                return new PersonalId($this->rawId);
            } catch (InvalidStructureException $e) {
                // Throw exception if coordination is disabled
                if (!$this->bUseCoord) {
                    throw $e;
                }
            }
        }

        // Create CoordinationId
        return new CoordinationId($this->rawId);
    }
}
