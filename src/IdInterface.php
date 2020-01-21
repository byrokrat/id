<?php

namespace byrokrat\id;

/**
 * The base id interface
 */
interface IdInterface
{
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
     *
     * NOTE that this is just a hint as birth date can not be guaranteed due to
     * the limited quantity of personal identity numbers per day.
     */
    public function getBirthDate(): \DateTimeImmutable;

    /**
     * Get age at date (defaults to current date)
     *
     * NOTE that this is just a hint as true age can not be guaranteed due to
     * the limited quantity of personal identity numbers per day.
     */
    public function getAge(\DateTimeInterface $atDate = null): int;

    /**
     * Get century part of date, 2 digits
     */
    public function getCentury(): string;

    /**
     * Get sex as denoted by id
     *
     * NOTE that this is just a hint and can not be guaranteed due to
     * the limited quantity of personal identity numbers per day.
     *
     * @see Sexes interface with idintifier constants
     */
    public function getSex(): string;

    /**
     * Check if id represents a male
     *
     * NOTE that this is just a hint and can not be guaranteed due to
     * the limited quantity of personal identity numbers per day.
     */
    public function isMale(): bool;

    /**
     * Check if id represents a female
     *
     * NOTE that this is just a hint and can not be guaranteed due to
     * the limited quantity of personal identity numbers per day.
     */
    public function isFemale(): bool;

    /**
     * Check if sex other than male/female is denoted
     */
    public function isSexOther(): bool;

    /**
     * Check if sex is not applicable
     */
    public function isSexUndefined(): bool;

    /**
     * Get string describing birth county
     *
     * @see Counties interface with idintifier constants
     */
    public function getBirthCounty(): string;

    /**
     * Get string describing legal form
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     *
     * @see LegalForms interface with idintifier constants
     */
    public function getLegalForm(): string;

    /**
     * Check if id legal form is undefined
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isLegalFormUndefined(): bool;

    /**
     * Check if id represents a state, county, municipality or parish
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isStateOrParish(): bool;

    /**
     * Check if id represents a incorporated company
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isIncorporated(): bool;

    /**
     * Check if id represents a partnership
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isPartnership(): bool;

    /**
     * Check if id represents a economic association
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isAssociation(): bool;

    /**
     * Check if id represents a non-profit organization or foundation
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isNonProfit(): bool;

    /**
     * Check if id represents a trading company, limited partnership or partnership
     *
     * NOTE that this is just a hint and does not conclusively determine the
     * legal form of the organization.
     */
    public function isTradingCompany(): bool;
}
