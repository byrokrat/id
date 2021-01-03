<?php

declare(strict_types=1);

namespace byrokrat\id\Helper;

use byrokrat\id\IdInterface;
use byrokrat\id\Counties;
use byrokrat\id\LegalForms;
use byrokrat\id\Sexes;
use byrokrat\id\Exception\DateNotSupportedException;
use byrokrat\id\Formatter\Formatter;

/**
 * Basic implementation of IdInterface
 */
trait BasicIdTrait
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
        return $this->format(IdInterface::FORMAT_10_DIGITS);
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
        $interval = $this->getBirthDate()->diff($atDate ?: new \DateTime());

        if (!$interval) {
            throw new \LogicException('Unable to create age interval');
        }

        return (int)$interval->format('%y');
    }

    public function getCentury(): string
    {
        return substr($this->getBirthDate()->format('Y'), 0, 2);
    }

    public function getSex(): string
    {
        return Sexes::SEX_UNDEFINED;
    }

    public function isMale(): bool
    {
        return $this->getSex() == Sexes::SEX_MALE;
    }

    public function isFemale(): bool
    {
        return $this->getSex() == Sexes::SEX_FEMALE;
    }

    public function isSexOther(): bool
    {
        return $this->getSex() == Sexes::SEX_OTHER;
    }

    public function isSexUndefined(): bool
    {
        return $this->getSex() == Sexes::SEX_UNDEFINED;
    }

    public function getBirthCounty(): string
    {
        return Counties::COUNTY_UNDEFINED;
    }

    public function getLegalForm(): string
    {
        return LegalForms::LEGAL_FORM_UNDEFINED;
    }

    public function isLegalFormUndefined(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_UNDEFINED;
    }

    public function isStateOrParish(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_STATE_PARISH;
    }

    public function isIncorporated(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_INCORPORATED;
    }

    public function isPartnership(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_PARTNERSHIP;
    }

    public function isAssociation(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_ASSOCIATION;
    }

    public function isNonProfit(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_NONPROFIT;
    }

    public function isTradingCompany(): bool
    {
        return $this->getLegalForm() == LegalForms::LEGAL_FORM_TRADING;
    }
}
