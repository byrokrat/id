<?php

namespace byrokrat\id;

/**
 * @deprecated Will be removed in version 2. Use IdInterface instead.
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
    const LEGAL_FORM_UNDEFINED = '';

    /**
     * State, county, municipality or parish legal form identifier
     */
    const LEGAL_FORM_STATE_PARISH = 'Stat, landsting, kommun eller församling';

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
     * Undefined county identifier
     */
    const COUNTY_UNDEFINED = '';

    /**
     * Stockholms county identifier
     */
    const COUNTY_STOCKHOLM = 'Stockholms stad';

    /**
     * Uppsala county identifier
     */
    const COUNTY_UPPSALA = 'Uppsala län';

    /**
     * Södermanlands county identifier
     */
    const COUNTY_SODERMANLAND = 'Södermanlands län';

    /**
     * Östergötlands county identifier
     */
    const COUNTY_OSTERGOTLAND = 'Östergötlands län';

    /**
     * Jönköpings county identifier
     */
    const COUNTY_JONKOPING = 'Jönköpings län';

    /**
     * Kronobergs county identifier
     */
    const COUNTY_KRONOBERG= 'Kronobergs län';

    /**
     * Kalmar county identifier
     */
    const COUNTY_KALMAR = 'Kalmar län';

    /**
     * Gotlands county identifier
     */
    const COUNTY_GOTLAND = 'Gotlands län';

    /**
     * Blekinge county identifier
     */
    const COUNTY_BLEKINGE = 'Blekinge län';

    /**
     * Kristianstads county identifier
     */
    const COUNTY_KRISTIANSTAD = 'Kristianstads län';

    /**
     * Malmöhus county identifier
     */
    const COUNTY_MALMOHUS = 'Malmöhus län';

    /**
     * Hallands county identifier
     */
    const COUNTY_HALLAND = 'Hallands län';

    /**
     * Göteborgs and Bohus county identifier
     */
    const COUNTY_GOTEBORG_BOUHUS = 'Göteborgs och Bohus län';

    /**
     * Älvsborgs county identifier
     */
    const COUNTY_ALVSBORG = 'Älvsborgs län';

    /**
     * Skaraborgs county identifier
     */
    const COUNTY_SKARABORG = 'Skaraborgs län';

    /**
     * Värmlands county identifier
     */
    const COUNTY_VARMLAND = 'Värmlands län';

    /**
     * Örebro county identifier
     */
    const COUNTY_OREBRO = 'Örebro län';

    /**
     * Västmanlands county identifier
     */
    const COUNTY_VASTMANLAND = 'Västmanlands län';

    /**
     * Kopparbergs county identifier
     */
    const COUNTY_KOPPARBERG = 'Kopparbergs län';

    /**
     * Gävleborgs county identifier
     */
    const COUNTY_GAVLEBORG = 'Gävleborgs län';

    /**
     * Västernorrlands county identifier
     */
    const COUNTY_VASTERNORRLAND = 'Västernorrlands län';

    /**
     * Jämtlands county identifier
     */
    const COUNTY_JAMTLAND = 'Jämtlands län';

    /**
     * Västerbottens county identifier
     */
    const COUNTY_VASTERBOTTEN = 'Västerbottens län';

    /**
     * Norrbottens county identifier
     */
    const COUNTY_NORRBOTTEN = 'Norrbottens län';

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
     * @return \DateTime
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
     * Get string describing birth county
     *
     * @return string One of the birth county identifier constants
     */
    public function getBirthCounty();

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
    public function isStateOrParish();

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
