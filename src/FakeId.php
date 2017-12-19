<?php

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

    /**
     * Fake personal identity numbers
     *
     * {@inheritdoc}
     *
     * @param string $number
     */
    public function __construct($number)
    {
        list(, $century, $datestr, $delimiter, $serialPost, $check) = $this->parseNumber(self::PATTERN, $number);
        parent::__construct($century . $datestr . $delimiter . '0000');
        $this->serialPost = $serialPost;
        $this->checkDigit = $check;
    }

    public function getSex()
    {
        return is_numeric($this->getSerialPostDelimiter()[2]) ? parent::getSex() : self::SEX_UNDEFINED;
    }

    public function getBirthCounty()
    {
        return IdInterface::COUNTY_UNDEFINED;
    }

    /**
     * Fake ids always have valid check digits
     */
    protected function validateCheckDigit()
    {
    }
}
