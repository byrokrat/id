<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Component;

use ledgr\id\Id;

/**
 * Helper that defines methods related to legal form
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait LegalForm
{
    /**
     * Get string describing legal form
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the organization.
     *
     * @return string One of the legal form identifier constants
     */
    public function getLegalForm()
    {
        return Id::LEGAL_FORM_UNDEFINED;
    }

    /**
     * Check if id legal form is undefined
     *
     * @return boolean
     */
    public function isLegalFormUndefined()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_UNDEFINED;
    }

    /**
     * Check if id represents a state, county, municipality or parish
     *
     * @return boolean
     */
    public function isStateOrCounty()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_STATE;
    }

    /**
     * Check if id represents a incorporated company
     *
     * @return boolean
     */
    public function isIncorporated()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_INCORPORATED;
    }

    /**
     * Check if id represents a partnership
     *
     * @return boolean
     */
    public function isPartnership()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_PARTNERSHIP;
    }

    /**
     * Check if id represents a economic association
     *
     * @return boolean
     */
    public function isAssociation()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_ASSOCIATION;
    }

    /**
     * Check if id represents a non-profit organization or foundation
     *
     * @return boolean
     */
    public function isNonProfit()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_NONPROFIT;
    }

    /**
     * Check if id represents a trading company, limited partnership or partnership
     *
     * @return boolean
     */
    public function isTradingCompany()
    {
        return $this->getLegalForm() == Id::LEGAL_FORM_TRADING;
    }
}
