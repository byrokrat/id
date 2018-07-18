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
     * Get sex as denoted by id
     *
     * @see Sexes interface with idintifier constants
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
     * Get string describing birth county
     *
     * @see Counties interface with idintifier constants
     */
    public function getBirthCounty(): string;

    /**
     * Get string describing legal form
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the organization.
     *
     * @see LegalForms interface with idintifier constants
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
