<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

use ledgr\id\Exception\InvalidStructureException;

/**
 * Fake swedish personal identity numbers
 *
 * Individual number replaced by xxxx, xx1x or xx2x.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class FakeId extends PersonalId
{
    /**
     * Fake swedish personal identity numbers
     *
     * @param  string                     $id
     * @throws InvalidStructureException  If structure is invalid
     * @throws InvalidCheckDigitException If check digit is invalid
     */
    public function __construct($id)
    {
        if (!preg_match("/^((?:\d\d)?)(\d{6})([-+])(xx[12x])(x)$/i", $id, $matches)) {
            throw new InvalidStructureException('Fake ids must use form (NN)NNNNNN-xx[12x]x');
        }

        list(, $century, $datestr, $delimiter, $individual, $check) = $matches;

        parent::__construct($century . $datestr . $delimiter . '0000');

        $this->setCheckDigit($check);
        $this->setIndividualNr($individual);
    }

    /**
     * Get sex as denoted by id
     *
     * Returns 'O' for other if sex could not be determined
     *
     * @return string
     */
    public function getSex()
    {
        $nr = $this->getIndividualNr();
        if (is_numeric($nr[2])) {

            return parent::getSex();
        } else {

            return 'O';
        }
    }

    /**
     * Calculate check digit
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        return '0';
    }
}
