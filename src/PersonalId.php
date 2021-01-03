<?php

declare(strict_types=1);

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
    private $dateOfBirth;

    /**
     * Create swedish personal identity number
     *
     * Format is YYYYMMDD(+-)NNNC or YYMMDD(+-)NNNC where parenthesis represents
     * an optional one char delimiter, N represents the individual number and C
     * the check digit. If year is set using two digits century is calculated
     * based on delimiter (+ signals more than a hundred years old). If year is
     * set using four digits delimiter is calculated based on century.
     *
     * @param string $raw The raw id to parse
     * @param \DateTimeInterface $atDate Optional date when parsing takes place, defaults to today
     * @throws UnableToCreateIdException On failure to create id
     */
    public function __construct(string $raw, \DateTimeInterface $atDate = null)
    {
        $atDate = $atDate ?: new \DateTime();

        list($century, $this->serialPre, $delimiter, $this->serialPost, $this->checkDigit)
            = NumberParser::parse(self::PATTERN, $raw);

        $this->delimiter = $delimiter ?: '-';

        if ($century) {
            // Date of birth is fully defined with 8 digits
            $dateOfBirth = DateTimeCreator::createFromFormat('Ymd', $century . $this->serialPre);

            // Calculate the first day the delimiter should be changed to '+'
            $firstDayCountingAsHundred = DateTimeCreator::createFromFormat('Ymd', $dateOfBirth->format('Y') . '0101');
            $firstDayCountingAsHundred->modify('+100 year');

            // Set delimiter based on current date
            $this->delimiter = $atDate < $firstDayCountingAsHundred ? '-' : '+';
        } else {
            // No century defined for date of birth, guess..
            $dateOfBirth = DateTimeCreator::createFromFormat('ymd', $this->serialPre);

            // If date of birth is in the future century is wrong
            if ($dateOfBirth > $atDate) {
                $dateOfBirth->modify('-100 year');
            }

            // If delimiter equals '+' date should be at least a hundred years ago
            if ($this->getDelimiter() == '+') {
                $dateOfBirth->modify('-100 year');
            }
        }

        // Validate that date is logically valid
        if ($dateOfBirth->format('ymd') != $this->serialPre) {
            throw new InvalidDateStructureException("Invalid date in {$this->getId()}");
        }

        $this->dateOfBirth = \DateTimeImmutable::createFromMutable($dateOfBirth);

        $this->validateCheckDigit();
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
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
