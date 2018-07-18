<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Fake personal identity numbers
 *
 * Fake ids replace serial number post delimiter with xxxx. If sex should be
 * encoded xxFx, xxMx or xxOx can be used, denoting Female, Male or Other.
 */
class FakeId extends PersonalId
{
    /**
     * Regular expression describing id structure
     */
    const PATTERN = '/^((?:\d\d)?)(\d{6})([-+]?)(xx[0-9xfmo])(x)$/i';

    public function __construct(string $number)
    {
        list(, $century, $datestr, $delimiter, $serialPost, $check) = $this->parseNumber(self::PATTERN, $number);
        parent::__construct($century . $datestr . $delimiter . '0000');
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

    /**
     * Fake ids always have valid check digits
     */
    protected function validateCheckDigit(): void
    {
    }
}
