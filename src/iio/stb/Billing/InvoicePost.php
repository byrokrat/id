<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Billing;

use iio\stb\Utils\Amount;

/**
 * An InvoicePost reresents a charged item, it's unit cost and VAT rate
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class InvoicePost
{
    /**
     * @var string Post description
     */
    private $description;

    /**
     * @var Amount Number of units
     */
    private $units;

    /**
     * @var Amount Cost per unit
     */
    private $unitCost;

    /**
     * @var Amount VAT rate
     */
    private $vat;

    /**
     * Constructor
     *
     * @param string $desc     Post description
     * @param Amount $units    Number of units
     * @param Amount $unitCost Cost per unit
     * @param Amount $vat      VAT rate, note that for 25% the value should be .25
     */
    public function __construct($desc, Amount $units, Amount $unitCost, Amount $vat = null)
    {
        $this->description = (string)$desc;
        $this->units = $units;
        $this->unitCost = $unitCost;
        $this->vat = $vat ?: new Amount('0');
    }

    /**
     * Get post description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get number of units
     *
     * @return Amount
     */
    public function getNrOfUnits()
    {
        return $this->units;
    }

    /**
     * Get cost per unit
     *
     * @return Amount
     */
    public function getUnitCost()
    {
        return $this->unitCost;
    }

    /**
     * Get total post cost
     *
     * @return Amount
     */
    public function getUnitTotal()
    {
        $cost = clone $this->getUnitCost();
        return $cost->multiplyWith($this->getNrOfUnits());
    }

    /**
     * Get VAT rate
     *
     * @return Amount
     */
    public function getVatRate()
    {
        return $this->vat;
    }

    /**
     * Get total VAT for post
     *
     * @return Amount
     */
    public function getVatTotal()
    {
        return $this->getUnitTotal()->multiplyWith($this->getVatRate());
    }
}
