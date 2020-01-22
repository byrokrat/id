<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\NumberParser;
use byrokrat\id\Exception\UnableToCreateIdException;

class FakeId extends PersonalId
{
    /**
     * Regular expression describing id structure
     */
    protected const PATTERN = '/^((?:\d\d)?)(\d{6})([-+]?)(xx[0-9xfmo])(x)$/i';

    /**
     * Create fake personal identity number
     *
     * Fake ids replace serial number post delimiter with xxxx. If sex should be
     * encoded xxFx, xxMx or xxOx can be used, denoting Female, Male or Other.
     *
     * @param string $raw The raw id to parse
     * @param \DateTimeInterface $atDate Optional date when parsing takes place, defaults to today
     * @throws UnableToCreateIdException On failure to create id
     */
    public function __construct(string $raw, \DateTimeInterface $atDate = null)
    {
        list($century, $datestr, $delimiter, $serialPost, $check) = NumberParser::parse(self::PATTERN, $raw);

        parent::__construct($century . $datestr . $delimiter . '0000', $atDate);

        $this->serialPost = $serialPost;
        $this->checkDigit = $check;
    }

    public function getSex(): string
    {
        foreach ([Sexes::SEX_FEMALE, Sexes::SEX_MALE, Sexes::SEX_OTHER, Sexes::SEX_UNDEFINED] as $sexIdentifier) {
            if (strcasecmp($sexIdentifier, $this->getSerialPostDelimiter()[2]) === 0) {
                return $sexIdentifier;
            }
        }

        return parent::getSex();
    }

    public function getBirthCounty(): string
    {
        return Counties::COUNTY_UNDEFINED;
    }

    protected function validateCheckDigit(): void
    {
        // Fake ids always have valid check digits
    }
}
