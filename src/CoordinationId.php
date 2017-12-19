<?php

namespace byrokrat\id;

/**
 * Coordination id number
 *
 * A coordination number is like a personal number except that 60 is added
 * to the date of birth.
 */
class CoordinationId extends PersonalId
{
    /**
     * Coordination id number
     *
     * {@inheritdoc}
     *
     * @param string $number
     */
    public function __construct($number)
    {
        list(, $century, $datestr, $delim, $serialPost, $check) = $this->parseNumber(self::PATTERN, $number);
        $dob = intval($datestr) - 60;
        parent::__construct($century.$dob.$delim.$serialPost.$check);
    }

    public function getSerialPreDelimiter()
    {
        return (string) intval(parent::getSerialPreDelimiter()) + 60;
    }

    public function getBirthCounty()
    {
        return IdInterface::COUNTY_UNDEFINED;
    }
}
