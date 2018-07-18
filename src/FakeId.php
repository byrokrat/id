<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Fake personal identity numbers
 *
 * Fake ids replace serial number post delimiter with xxxx. If sex should be
 * encoded xx1x or xx2x can be used.
 */
class FakeId extends PersonalId
{
    /**
     * Regular expression describing id structure
     */
    const PATTERN = '/^((?:\d\d)?)(\d{6})([-+]?)(xx[12x])(x)$/i';

    public function __construct(string $number)
    {
        list(, $century, $datestr, $delimiter, $serialPost, $check) = $this->parseNumber(self::PATTERN, $number);
        parent::__construct($century . $datestr . $delimiter . '0000');
        $this->serialPost = $serialPost;
        $this->checkDigit = $check;
    }

    public function getSex(): string
    {
        return is_numeric($this->getSerialPostDelimiter()[2]) ? parent::getSex() : Sexes::SEX_UNDEFINED;
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
