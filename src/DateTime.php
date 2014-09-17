<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Simple DateTime extension to throw exception if createFromFormat failes
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class DateTime extends\DateTime
{
    /**
     * Returns new DateTime object formatted according to the specified format
     *
     * @param  string $format The format that the passed in string should be in
     * @param  string $time   String representing the time
     * @return DateTime
     * @throws Exception\InvalidDateStructureException If creation fail
     */
    static public function createFromFormat($format, $time)
    {
        if ($dateTime = parent::createFromFormat($format, $time)) {
            return $dateTime;
        }

        $errors = parent::getLastErrors();

        $msg = trim(
            implode(
                ', ',
                array_merge($errors['errors'], $errors['warnings'])
            )
        );

        throw new Exception\InvalidDateStructureException($msg);
    }
}
