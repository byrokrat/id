<?php

declare(strict_types = 1);

namespace byrokrat\id\Helper;

use byrokrat\id\IdInterface;
use byrokrat\id\Exception\DateNotSupportedException;
use byrokrat\id\Exception\InvalidCheckDigitException;
use byrokrat\id\Exception\InvalidStructureException;
use byrokrat\id\Formatter\Formatter;

/**
 * Standard implementation of IdInterface
 */
abstract class AbstractId implements IdInterface
{
    /**
     * @var string
     */
    protected $serialPre = '000000';

    /**
     * @var string
     */
    protected $serialPost = '000';

    /**
     * @var string Date and control string delimiter (- or +)
     */
    protected $delimiter = '-';

    /**
     * @var string
     */
    protected $checkDigit = '0';

    public function getId(): string
    {
        return $this->getSerialPreDelimiter()
            . $this->getDelimiter()
            . $this->getSerialPostDelimiter()
            . $this->getCheckDigit();
    }

    public function __tostring(): string
    {
        return $this->getId();
    }

    public function format(string $format): string
    {
        return (new Formatter($format))->format($this);
    }

    public function getSerialPreDelimiter(): string
    {
        return $this->serialPre;
    }

    public function getSerialPostDelimiter(): string
    {
        return $this->serialPost;
    }

    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    public function getCheckDigit(): string
    {
        return $this->checkDigit;
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        throw new DateNotSupportedException("Trying to access date on id type where it is not supported");
    }

    public function getAge(\DateTimeInterface $atDate = null): int
    {
        return (int)$this->getBirthDate()->diff($atDate ?: new \DateTime)->format('%y');
    }

    public function getCentury(): string
    {
        return substr($this->getBirthDate()->format('Y'), 0, 2);
    }

    public function getSex(): string
    {
        return IdInterface::SEX_UNDEFINED;
    }

    public function isMale(): bool
    {
        return $this->getSex() == IdInterface::SEX_MALE;
    }

    public function isFemale(): bool
    {
        return $this->getSex() == IdInterface::SEX_FEMALE;
    }

    public function isSexUndefined(): bool
    {
        return $this->getSex() == IdInterface::SEX_UNDEFINED;
    }

    public function getBirthCounty(): string
    {
        return IdInterface::COUNTY_UNDEFINED;
    }

    public function getLegalForm(): string
    {
        return IdInterface::LEGAL_FORM_UNDEFINED;
    }

    public function isLegalFormUndefined(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_UNDEFINED;
    }

    public function isStateOrParish(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_STATE_PARISH;
    }

    public function isIncorporated(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_INCORPORATED;
    }

    public function isPartnership(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_PARTNERSHIP;
    }

    public function isAssociation(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_ASSOCIATION;
    }

    public function isNonProfit(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_NONPROFIT;
    }

    public function isTradingCompany(): bool
    {
        return $this->getLegalForm() == IdInterface::LEGAL_FORM_TRADING;
    }

    /**
     * Parse id using regular expression
     *
     * @return string[] Array of matches
     *
     * @throws InvalidStructureException If regular expression does not match
     */
    protected function parseNumber(string $regexp, string $raw): array
    {
        if (!preg_match($regexp, $raw, $matches)) {
            throw new InvalidStructureException("Unable to parse $raw, invalid structure");
        }

        return $matches;
    }

    /**
     * Verify that the last digit of id is a valid check digit
     *
     * @throws InvalidCheckDigitException If check digit is not valid
     */
    protected function validateCheckDigit(): void
    {
        if (!Modulo10::isValid(preg_replace('/[^0-9]/', '', $this->getId()))) {
            throw new InvalidCheckDigitException("Invalid check digit in {$this->getId()}");
        }
    }
}
