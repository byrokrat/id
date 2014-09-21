<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Fake personal identity numbers
 *
 * Fake ids replace serial number post delimiter with xxxx. If sex should be
 * encoded xx1x or xx2x can be used.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
     * @param string $id
     */
    public function __construct($id)
    {
        list(, $century, $datestr, $delimiter, $serialPost, $check) = FakeId::parseStructure($id);
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
