<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Creates DateTime objects and throws exception if createFromFormat failes
 */
class DateTimeCreator
{
    /**
     * Returns new DateTime object formatted according to the specified format
     *
     * @throws Exception\InvalidDateStructureException If creation fail
     */
    public static function createFromFormat(string $format, string $date): \DateTime
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
