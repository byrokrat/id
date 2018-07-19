<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\BasicIdTrait;
use byrokrat\id\Helper\DateTimeCreator;
use byrokrat\id\Helper\Modulo10;
use byrokrat\id\Helper\NumberParser;

/**
 * Swedish personal identity numbers
 */
class PersonalId implements IdInterface
{
    use BasicIdTrait;

    /**
     * Regular expression describing id structure
     */
    protected const PATTERN = '/^((?:\d\d)?)(\d{6})([-+]?)(\d{3})(\d)$/';

    /**
     * Maps county numbers high limit to county identifiers
     */
    private const BIRTH_COUNTY_MAP = [
        13 => Counties::COUNTY_STOCKHOLM,
        15 => Counties::COUNTY_UPPSALA,
        18 => Counties::COUNTY_SODERMANLAND,
        23 => Counties::COUNTY_OSTERGOTLAND,
        26 => Counties::COUNTY_JONKOPING,
        28 => Counties::COUNTY_KRONOBERG,
        31 => Counties::COUNTY_KALMAR,
        32 => Counties::COUNTY_GOTLAND,
        34 => Counties::COUNTY_BLEKINGE,
        38 => Counties::COUNTY_KRISTIANSTAD,
        45 => Counties::COUNTY_MALMOHUS,
        47 => Counties::COUNTY_HALLAND,
        54 => Counties::COUNTY_GOTEBORG_BOUHUS,
        58 => Counties::COUNTY_ALVSBORG,
        61 => Counties::COUNTY_SKARABORG,
        64 => Counties::COUNTY_VARMLAND,
        65 => Counties::COUNTY_UNDEFINED,
        68 => Counties::COUNTY_OREBRO,
        70 => Counties::COUNTY_VASTMANLAND,
        73 => Counties::COUNTY_KOPPARBERG,
        74 => Counties::COUNTY_UNDEFINED,
        77 => Counties::COUNTY_GAVLEBORG,
        81 => Counties::COUNTY_VASTERNORRLAND,
        84 => Counties::COUNTY_JAMTLAND,
        88 => Counties::COUNTY_VASTERBOTTEN,
        92 => Counties::COUNTY_NORRBOTTEN,
    ];

    /**
     * @var \DateTimeImmutable
     */
    private $dob;

    /**
     * Swedish personal identity numbers
     *
     * Format is YYYYMMDD(+-)NNNC or YYMMDD(+-)NNNC where parenthesis represents
     * an optional one char delimiter, N represents the individual number and C
     * the check digit. If year is set using two digits century is calculated
     * based on delimiter (+ signals more than a hundred years old). If year is
     * set using four digits delimiter is calculated based on century.
     *
     * @throws Exception\InvalidDateStructureException If date is not logically valid
     */
    public function __construct(string $number)
    {
        list(, $century, $this->serialPre, $delimiter, $this->serialPost, $this->checkDigit)
            = NumberParser::parse(self::PATTERN, $number);

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
            throw new Exception\InvalidDateStructureException("Invalid date in {$this->getId()}");
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

            foreach (self::BIRTH_COUNTY_MAP as $limit => $identifier) {
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
