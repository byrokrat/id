<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
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
