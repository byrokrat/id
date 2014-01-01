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

use iio\stb\ID\IdInterface;
use iio\stb\ID\NullId;
use iio\stb\Banking\BankAccountInterface;
use iio\stb\Banking\NullAccount;

/**
 * A LegalPerson is a container for id, accounts and more
 *
 * Legal persons are of two kinds: natural persons (people) and juridical persons,
 * groups of people, such as corporations, which are treated by law as if they were persons.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class LegalPerson
{
    /**
     * @var string Name of this legal person
     */
    private $name;

    /**
     * @var IdInterface Personal identifier
     */
    private $id;

    /**
     * @var BankAccountInterface Account registered with person
     */
    private $account;

    /**
     * @var string Optional customer number for billing
     */
    private $customerNr;

    /**
     * @var boolean Flag if this person is a corporation
     */
    private $corporation = false;

    /**
     * @var string Optional VAT number for corporations
     */
    private $vatNr = '';

    /**
     * Construct legal person container
     *
     * @param string               $name        Name of legal person
     * @param IdInterface          $id          Peronal identifier
     * @param BankAccountInterface $account     Account number
     * @param string               $customerNr  Customer number for billing
     * @param boolean              $corporation Flag if person is a corporation
     * @param boolean              $vat         Flag if corporation is registered for VAT
     */
    public function __construct(
        $name,
        IdInterface $id = null,
        BankAccountInterface $account = null,
        $customerNr = '',
        $corporation = false,
        $vat = false
    ) {
        $this->name = (string)$name;
        $this->id = $id;
        $this->account = $account;
        $this->customerNr = (string)$customerNr;
        $this->corporation = (bool)$corporation;
        if ($corporation && $vat) {
            $this->vatNr = str_replace(array('-', '+'), '', "SE{$id}01");
        }
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get personal identifier
     *
     * @return IdInterface
     */
    public function getId()
    {
        return $this->id ?: new NullId;
    }

    /**
     * Get account
     *
     * @return BankAccountInterface
     */
    public function getAccount()
    {
        return $this->account ?: new NullAccount;
    }

    /**
     * Get customer number
     *
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->customerNr;
    }

    /**
     * Check if person is corporation
     *
     * @return boolean
     */
    public function isCorporation()
    {
        return $this->corporation;
    }

    /**
     * Get swedish VAT number
     *
     * @see http://sv.wikipedia.org/wiki/Momsregistreringsnummer
     * 
     * @return string VAT number
     */
    public function getVatNr()
    {
        return $this->vatNr;
    }
}
