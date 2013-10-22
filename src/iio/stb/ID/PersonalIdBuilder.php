<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\ID;

use iio\stb\Exception;

/**
 * Build personal ids
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class PersonalIdBuilder
{
    /**
     * @var bool Flag if fake id is allowed
     */
    private $bUseFake = false;

    /**
     * @var bool Flag if coordination id is allowed
     */
    private $bUseCoord = true;

    /**
     * @var string Unprocessed id
     */
    private $rawId = '';

    /**
     * Set unproccessed id
     *
     * @param  string            $rawId
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function setId($rawId)
    {
        assert('is_string($rawId)');
        $this->rawId = $rawId;

        return $this;
    }

    /**
     * Enable fake id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function enableFakeId()
    {
        $this->bUseFake = true;

        return $this;
    }

    /**
     * Disable fake id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function disableFakeId()
    {
        $this->bUseFake = false;

        return $this;
    }

    /**
     * Enable coordination id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function enableCoordinationId()
    {
        $this->bUseCoord = true;

        return $this;
    }

    /**
     * Disable coordination id
     *
     * @return PersonalIdBuilder Returns instance to enable chaining
     */
    public function disableCoordinationId()
    {
        $this->bUseCoord = false;

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
     * @throws Exception  If id could not be built
     */
    public function getId()
    {
        // Create PersonalId
        try {
            return new PersonalId($this->rawId);
        } catch (Exception $e) {
            // Throw exception if coord and fake are disabled
            if (!$this->bUseCoord && !$this->bUseFake) {
                throw $e;
            }
        }

        // Create CoordinationId
        if ($this->bUseCoord) {
            try {
                return new CoordinationId($this->rawId);
            } catch (Exception $e) {
                // Throw exception if fake is disabled
                if (!$this->bUseFake) {
                    throw $e;
                }
            }
        }

        // Create FakeId
        return new FakeId($this->rawId);
    }
}
