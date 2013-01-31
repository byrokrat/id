<?php
/**
 * This file is part of the stb package
 *
 * Copyright (c) 2012-13 Hannes Forsgård
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Hannes Forsgård <hannes.forsgard@gmail.com>
 * @package stb\ID
 */

namespace iio\stb\ID;

use iio\stb\Exception\InvalidStructureException;

/**
 * Fake swedish personal identity numbers
 *
 * Individual number replaced by xxxx, xx1x or xx2x.
 *
 * @package stb\ID
 */
class FakeId extends PersonalId
{
    /**
     * Set id number
     *
     * @param string $id
     *
     * @return void
     *
     * @throws InvalidStructureException if structure is invalid
     * @throws InvalidCheckDigitException if check digit is invalid
     */
    public function setId($id)
    {
        assert('is_string($id)');

        $split = preg_split("/([-+])/", $id, 2, PREG_SPLIT_DELIM_CAPTURE);
        if (count($split) != 3) {
            $msg = 'IDs must use form (NN)NNNNNN-xxxx or (NN)NNNNNN+xxxx';
            throw new InvalidStructureException($msg);
        }

        $control = strtolower($split[2]);

        if (!in_array($control, array('xxxx', 'xx1x', 'xx2x'))) {
            $msg = 'Fake id control number must be xxxx, xx1x or xx2x';
            throw new InvalidStructureException($msg);
        }

        parent::setId($split[0] . $split[1] . '0000');

        $this->setCheckDigit('x');
        $this->setIndividualNr(substr($control, 0, 3));
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
