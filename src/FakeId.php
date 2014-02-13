<?php
/**
 * This file is part of ledgr/id.
 *
 * Copyright (c) 2014 Hannes Forsgård
 *
 * ledgr/id is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ledgr/id is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ledgr/id.  If not, see <http://www.gnu.org/licenses/>.
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
