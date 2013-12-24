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
 * Build corporate ids
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class CorporateIdBuilder
{
    /**
     * @var bool Flag if personal id is allowed
     */
    private $bUsePersonal = true;

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
     * @param  string             $rawId
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
     * @return IdInterface
     * @throws Exception   If id could not be built
     */
    public function getId()
    {
        // Create CorporateId
        try {
            return new CorporateId($this->rawId);
        } catch (Exception $e) {
            // Throw exception if coord and personal id are disabled
            if (!$this->bUseCoord && !$this->bUsePersonal) {
                throw $e;
            }
        }

        // Create PersonalId
        if ($this->bUsePersonal) {
            try {
                return new PersonalId($this->rawId);
            } catch (Exception $e) {
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
