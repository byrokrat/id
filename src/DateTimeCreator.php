<?php

namespace byrokrat\id;

/**
 * Creates DateTime objects and throws exception if createFromFormat failes
 */
class DateTimeCreator
{
    /**
     * Returns new DateTime object formatted according to the specified format
     *
     * @param  string         $format   The format that the passed in string should be in
     * @param  string         $date     String representing the time
     * @return \DateTime
     * @throws Exception\InvalidDateStructureException If creation fail
     */
    public static function createFromFormat($format, $date)
    {
        if ($dateTime = \DateTime::createFromFormat($format, $date)) {
            $dateTime->setTime(0, 0, 0);
            return $dateTime;
        }

        $errors = \DateTime::getLastErrors();

        $msg = trim(
            implode(
                ', ',
                array_merge($errors['errors'], $errors['warnings'])
            )
        );

        throw new Exception\InvalidDateStructureException($msg);
    }
}
