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
    use Component\BirthCounty;

    /**
     * {@inheritdoc}
     *
     * @param string $number
     */
    public function __construct($number)
    {
        list(, $century, $datestr, $delim, $serialPost, $check) = CoordinationId::parseStructure($number);
        $dob = intval($datestr) - 60;
        parent::__construct($century.$dob.$delim.$serialPost.$check);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getSerialPreDelimiter()
    {
        return (string) intval(parent::getSerialPreDelimiter()) + 60;
    }
}
