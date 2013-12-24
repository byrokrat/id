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

/**
 * Id Interface
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface IdInterface
{
    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit();

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter();

    /**
     * Get id
     *
     * @return string
     */
    public function getId();

    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring();
}
