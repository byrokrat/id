<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\Exception\InvalidDateStructureException;

class DateTimeCreator
{
    /**
     * Returns new DateTime object formatted according to the specified format
     *
     * @throws InvalidDateStructureException If creation fail
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
                // @phpstan-ignore-next-line
                array_merge((array)($errors['errors'] ?? []), (array)($errors['warnings'] ?? []))
            )
        );

        throw new InvalidDateStructureException($msg);
    }
}
