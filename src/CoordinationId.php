<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\DateTimeCreator;
use byrokrat\id\Helper\NumberParser;
use byrokrat\id\Exception\UnableToCreateIdException;

class CoordinationId extends PersonalId
{
    /**
     * @var string
     */
    private $datestr;

    /**
     * Create coordination id number
     *
     * A coordination number is like a personal number except that 60 is added
     * to the date of birth.
     *
     * NOTE that coordination numbers may contain a date that does not actually
     * exist. The month and day parts may on some cases be set to '00'. And
     * the day part may in some cases refer to undefined dates, such as the 30th
     * of february. In these cases the parser will convert the date to a valid
     * date, even though it may not reflect the actual birth date.
     *
     * @throws UnableToCreateIdException On failure to create id
     */
    public function __construct(string $raw)
    {
        list($century, $this->datestr, $delim, $serialPost, $check) = NumberParser::parse(self::PATTERN, $raw);

        // remove 60 and preserve left side zeros
        $compensatedDatestr = str_pad((string)(intval($this->datestr) - 60), 6, '0', STR_PAD_LEFT);
        $compensatedFormat = 'ymd';

        if ($century) {
            $compensatedDatestr = $century . $compensatedDatestr;
            $compensatedFormat = 'Ymd';
        }

        // parse a date of birth even though datestr may refer a date that does not actually exist
        $dateOfBirth = DateTimeCreator::createFromFormat($compensatedFormat, $compensatedDatestr);

        parent::__construct($century . $dateOfBirth->format('ymd') . $delim . $serialPost . $check);
    }

    public function getSerialPreDelimiter(): string
    {
        return $this->datestr;
    }

    public function getBirthCounty(): string
    {
        return Counties::COUNTY_UNDEFINED;
    }
}
