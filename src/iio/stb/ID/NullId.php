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
 * IdInterface null object
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class NullId implements IdInterface
{
    /**
     * @var string String returned by getId()
     */
    private static $str = '-';

    /**
     * Set string returned by getId()
     *
     * @param  string $str
     * @return void
     */
    public static function setString($str)
    {
        self::$str = $str;
    }

    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit()
    {
        return '0';
    }

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter()
    {
        return '-';
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return self::$str;
    }

    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring()
    {
        return $this->getId();
    }
}
