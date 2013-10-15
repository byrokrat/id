<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iio\stb\ID;

use iio\stb\Exception\InvalidStructureException;

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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     *
     * @return string
     */
    protected function calcCheckDigit()
    {
        return '0';
    }
}
