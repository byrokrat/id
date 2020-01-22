<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\BasicIdTrait;
use byrokrat\id\Helper\DateTimeCreator;
use byrokrat\id\Helper\Modulo10;
use byrokrat\id\Helper\NumberParser;
use byrokrat\id\Exception\InvalidDateStructureException;
use byrokrat\id\Exception\UnableToCreateIdException;

class PersonalId implements IdInterface
{
    use BasicIdTrait;

    /**
     * Regular expression describing id structure
     */
    protected const PATTERN = '/^((?:\d\d)?)(\d{6})([-+]?)(\d{3})(\d)$/';

    /**
     * @var \DateTimeImmutable
     */
    private $dob;

    /**
     * Create swedish personal identity number
     *
     * Format is YYYYMMDD(+-)NNNC or YYMMDD(+-)NNNC where parenthesis represents
     * an optional one char delimiter, N represents the individual number and C
     * the check digit. If year is set using two digits century is calculated
     * based on delimiter (+ signals more than a hundred years old). If year is
     * set using four digits delimiter is calculated based on century.
     *
     * @throws UnableToCreateIdException On failure to create id
     */
    public function __construct(string $raw)
    {
        list($century, $this->serialPre, $delimiter, $this->serialPost, $this->checkDigit)
            = NumberParser::parse(self::PATTERN, $raw);

        $this->delimiter = $delimiter ?: '-';

        if ($century) {
            // Set delimiter based on date (+ if date is more then a hundred years old)
            $date = DateTimeCreator::createFromFormat('Ymd', $century.$this->serialPre);
            $hundredYearsAgo = new \DateTime;
            $hundredYearsAgo->modify('-100 year');
            $this->delimiter = $date < $hundredYearsAgo ? '+' : '-';
        } else {
            // No century defined
            $date = DateTimeCreator::createFromFormat('ymd', $this->serialPre);

            // If in the future century is wrong
            if ($date > new \DateTime) {
                $date->modify('-100 year');
            }

            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $date->modify('-100 year');
            }
        }

        // Validate that date is logically valid
        if ($date->format('ymd') != $this->serialPre) {
            throw new InvalidDateStructureException("Invalid date in {$this->getId()}");
        }

        $this->dob = \DateTimeImmutable::createFromMutable($date);

        $this->validateCheckDigit();
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return $this->dob;
    }

    public function getSex(): string
    {
        return (intval($this->getSerialPostDelimiter()[2]) % 2 == 0) ? Sexes::SEX_FEMALE : Sexes::SEX_MALE;
    }

    public function getBirthCounty(): string
    {
        if ($this->getBirthDate() < DateTimeCreator::createFromFormat('Ymd', '19900101')) {
            $countyNr = (int)substr($this->getSerialPostDelimiter(), 0, 2);

            foreach (Counties::COUNTY_NUMBER_MAP as $limit => $identifier) {
                if ($countyNr <= $limit) {
                    return $identifier;
                }
            }
        }

        return Counties::COUNTY_UNDEFINED;
    }

    protected function validateCheckDigit(): void
    {
        Modulo10::validateCheckDigit($this);
    }
}
