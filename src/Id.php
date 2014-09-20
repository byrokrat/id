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
 * Basic id interface
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface Id
{
    /**
     * Male sex identifier
     */
    const SEX_MALE = 'M';

    /**
     * Female sex identifier
     */
    const SEX_FEMALE = 'F';

    /**
     * Undefined or other sex identifier
     */
    const SEX_UNDEFINED = 'O';

    /**
     * Undefined legal form identifier
     */
    const LEGAL_FORM_UNDEFINED = 'Okänd';

    /**
     * State, county, municipality or parish legal form identifier
     */
    const LEGAL_FORM_STATE = 'Stat, landsting, kommun eller församling';

    /**
     * Incorporated company legal form identifier
     */
    const LEGAL_FORM_INCORPORATED = 'Aktiebolag';

    /**
     * Partnership legal form identifier
     */
    const LEGAL_FORM_PARTNERSHIP = 'Enkelt bolag';

    /**
     * Economic association legal form identifier
     */
    const LEGAL_FORM_ASSOCIATION = 'Ekonomisk förening';

    /**
     * Non-profit organization or foundation legal form identifier
     */
    const LEGAL_FORM_NONPROFIT = 'Ideell förening eller stiftelse';

    /**
     * Trading company, limited partnership or partnership legal form identifier
     */
    const LEGAL_FORM_TRADING = 'Handelsbolag, kommanditbolag eller enkelt bolag';

    /**
     * Get id as string
     *
     * @return string
     */
    public function getId();

    /**
     * Get id as string
     *
     * @return string
     */
    public function __tostring();

    /**
     * Format id according to format string
     *
     * @param  string $format
     * @return string
     */
    public function format($format);

    /**
     * Get part of serial number before delimiter, 6 digits
     *
     * @return string
     */
    public function getSerialPreDelimiter();

    /**
     * Get part of serial number after delimiter, 3 digits
     *
     * @return string
     */
    public function getSerialPostDelimiter();

    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter();

    /**
     * Get check digit
     *
     * @return string
     */
    public function getCheckDigit();

    /**
     * Get birth date
     *
     * @return DateTime
     */
    public function getDate();

    /**
     * Get current age
     *
     * @return int
     */
    public function getAge();

    /**
     * Get century part of date, 2 digits
     *
     * @return string
     */
    public function getCentury();

    /**
     * Get sex as denoted by id
     *
     * @return string One of the sex identifier constants
     */
    public function getSex();

    /**
     * Check if id represents a male
     *
     * @return boolean
     */
    public function isMale();

    /**
     * Check if id represents a female
     *
     * @return boolean
     */
    public function isFemale();

    /**
     * Check if sex not applicable
     *
     * @return boolean
     */
    public function isSexUndefined();

    /**
     * Get string describing legal form
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the organization.
     *
     * @return string One of the legal form identifier constants
     */
    public function getLegalForm();

    /**
     * Check if id legal form is undefined
     *
     * @return boolean
     */
    public function isLegalFormUndefined();

    /**
     * Check if id represents a state, county, municipality or parish
     *
     * @return boolean
     */
    public function isStateOrCounty();

    /**
     * Check if id represents a incorporated company
     *
     * @return boolean
     */
    public function isIncorporated();

    /**
     * Check if id represents a partnership
     *
     * @return boolean
     */
    public function isPartnership();

    /**
     * Check if id represents a economic association
     *
     * @return boolean
     */
    public function isAssociation();

    /**
     * Check if id represents a non-profit organization or foundation
     *
     * @return boolean
     */
    public function isNonProfit();

    /**
     * Check if id represents a trading company, limited partnership or partnership
     *
     * @return boolean
     */
    public function isTradingCompany();
}
