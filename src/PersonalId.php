<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Swedish personal identity numbers
 */
class PersonalId extends AbstractId
{
    /**
     * Regular expression describing id structure
     */
    const PATTERN = '/^((?:\d\d)?)(\d{6})([-+]?)(\d{3})(\d)$/';

    /**
     * Maps county numbers high limit to county identifiers
     */
    private const BIRTH_COUNTY_MAP = [
        13 => IdInterface::COUNTY_STOCKHOLM,
        15 => IdInterface::COUNTY_UPPSALA,
        18 => IdInterface::COUNTY_SODERMANLAND,
        23 => IdInterface::COUNTY_OSTERGOTLAND,
        26 => IdInterface::COUNTY_JONKOPING,
        28 => IdInterface::COUNTY_KRONOBERG,
        31 => IdInterface::COUNTY_KALMAR,
        32 => IdInterface::COUNTY_GOTLAND,
        34 => IdInterface::COUNTY_BLEKINGE,
        38 => IdInterface::COUNTY_KRISTIANSTAD,
        45 => IdInterface::COUNTY_MALMOHUS,
        47 => IdInterface::COUNTY_HALLAND,
        54 => IdInterface::COUNTY_GOTEBORG_BOUHUS,
        58 => IdInterface::COUNTY_ALVSBORG,
        61 => IdInterface::COUNTY_SKARABORG,
        64 => IdInterface::COUNTY_VARMLAND,
        65 => IdInterface::COUNTY_UNDEFINED,
        68 => IdInterface::COUNTY_OREBRO,
        70 => IdInterface::COUNTY_VASTMANLAND,
        73 => IdInterface::COUNTY_KOPPARBERG,
        74 => IdInterface::COUNTY_UNDEFINED,
        77 => IdInterface::COUNTY_GAVLEBORG,
        81 => IdInterface::COUNTY_VASTERNORRLAND,
        84 => IdInterface::COUNTY_JAMTLAND,
        88 => IdInterface::COUNTY_VASTERBOTTEN,
        92 => IdInterface::COUNTY_NORRBOTTEN,
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
            = $this->parseNumber(self::PATTERN, $number);

        $this->delimiter = $delimiter ?: '-';

        if ($century) {
            // Set delimiter based on date (+ if date is more then a hundred years old)
            $date = DateTimeCreator::createFromFormat('Ymd', $century.$this->serialPre);
            $hundredYearsAgo = new \DateTime();
            $hundredYearsAgo->modify('-100 year');
            $this->delimiter = $date < $hundredYearsAgo ? '+' : '-';
        } else {
            // No century defined
            $date = DateTimeCreator::createFromFormat('ymd', $this->serialPre);

            // If in the future century is wrong
            if ($date > new \DateTime()) {
                $date->modify('-100 year');
            }

            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $date->modify('-100 year');
            }
        }

        // Validate that date is logically valid
        if ($date->format('ymd') != $this->serialPre) {
            throw new Exception\InvalidDateStructureException("Invalid date in <{$this->getId()}>");
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
        return (intval($this->getSerialPostDelimiter()[2])%2 == 0) ? self::SEX_FEMALE : self::SEX_MALE;
    }

    public function getBirthCounty(): string
    {
        if ($this->getBirthDate() < DateTimeCreator::createFromFormat('Ymd', '19900101')) {
            $countyNr = (int) substr($this->getSerialPostDelimiter(), 0, 2);
            foreach (self::BIRTH_COUNTY_MAP as $limit => $identifier) {
                if ($countyNr <= $limit) {
                    return $identifier;
                }
            }
        }

        return IdInterface::COUNTY_UNDEFINED;
    }
}
