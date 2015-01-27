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
    use Component\BirthCounty;

    /**
     * @var string Regular expression describing structure
     */
    protected static $structure = '/^((?:\d\d)?)(\d{6})([-+]?)(xx[12x])(x)$/i';

    /**
     * {@inheritdoc}
     *
     * @param string $number
     */
    public function __construct($number)
    {
        list(, $century, $datestr, $delimiter, $serialPost, $check) = FakeId::parseStructure($number);
        parent::__construct($century . $datestr . $delimiter . '0000');
        $this->serialPost = $serialPost;
        $this->checkDigit = $check;
    }

    /**
     * {@inheritdoc}
     *
     * @return string One of the sex identifier constants
     */
    public function getSex()
    {
        return is_numeric($this->getSerialPostDelimiter()[2]) ? parent::getSex() : self::SEX_UNDEFINED;
    }

    /**
     * Fake ids always have valid check digits
     *
     * @return void
     */
    protected function validateCheckDigit()
    {
    }
}
