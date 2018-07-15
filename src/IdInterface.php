<?php

namespace byrokrat\id;

/**
 * The base id interface
 */
interface IdInterface
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
     */
    public function getId(): string;

    /**
     * Get id as string
     */
    public function __tostring(): string;

    /**
     * Format id according to format string
     */
    public function format(string $format): string;

    /**
     * Get part of serial number before delimiter, 6 digits
     */
    public function getSerialPreDelimiter(): string;

    /**
     * Get part of serial number after delimiter, 3 digits
     */
    public function getSerialPostDelimiter(): string;

    /**
     * Get delimiter
     */
    public function getDelimiter(): string;

    /**
     * Get check digit
     */
    public function getCheckDigit(): string;

    /**
     * Get birth date
     */
    public function getBirthDate(): \DateTimeImmutable;

    /**
     * Get age at date (defaults to current date)
     */
    public function getAge(\DateTimeInterface $atDate = null): int;

    /**
     * Get century part of date, 2 digits
     */
    public function getCentury(): string;

    /**
     * Get sex as denoted by id (as one of the sex identifier constants)
     */
    public function getSex(): string;

    /**
     * Check if id represents a male
     */
    public function isMale(): bool;

    /**
     * Check if id represents a female
     */
    public function isFemale(): bool;

    /**
     * Check if sex not applicable
     */
    public function isSexUndefined(): bool;

    /**
     * Get string describing birth county (one of the birth county identifier constants)
     */
    public function getBirthCounty(): string;

    /**
     * Get string describing legal form (one of the legal form identifier constants)
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the organization.
     */
    public function getLegalForm(): string;

    /**
     * Check if id legal form is undefined
     */
    public function isLegalFormUndefined(): bool;

    /**
     * Check if id represents a state, county, municipality or parish
     */
    public function isStateOrParish(): bool;

    /**
     * Check if id represents a incorporated company
     */
    public function isIncorporated(): bool;

    /**
     * Check if id represents a partnership
     */
    public function isPartnership(): bool;

    /**
     * Check if id represents a economic association
     */
    public function isAssociation(): bool;

    /**
     * Check if id represents a non-profit organization or foundation
     */
    public function isNonProfit(): bool;

    /**
     * Check if id represents a trading company, limited partnership or partnership
     */
    public function isTradingCompany(): bool;
}
