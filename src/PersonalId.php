<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id;

/**
 * Swedish personal identity numbers
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class PersonalId implements Id
{
    use Component\Structure, Component\BaseImplementation;

    /**
     * @var string Regular expression describing structure
     */
    protected static $structure = '/^((?:\d\d)?)(\d{6})([-+]?)(\d{3})(\d)$/';

    /**
     * @var string[] Map of county number high limit to county identifier
     */
    static private $birthCountyMap = [
        13 => Id::COUNTY_STOCKHOLM,
        15 => Id::COUNTY_UPPSALA,
        18 => Id::COUNTY_SODERMANLAND,
        23 => Id::COUNTY_OSTERGOTLAND,
        26 => Id::COUNTY_JONKOPING,
        28 => Id::COUNTY_KRONOBERG,
        31 => Id::COUNTY_KALMAR,
        32 => Id::COUNTY_GOTLAND,
        34 => Id::COUNTY_BLEKINGE,
        38 => Id::COUNTY_KRISTIANSTAD,
        45 => Id::COUNTY_MALMOHUS,
        47 => Id::COUNTY_HALLAND,
        54 => Id::COUNTY_GOTEBORG_BOUHUS,
        58 => Id::COUNTY_ALVSBORG,
        61 => Id::COUNTY_SKARABORG,
        64 => Id::COUNTY_VARMLAND,
        65 => Id::COUNTY_UNDEFINED,
        68 => Id::COUNTY_OREBRO,
        70 => Id::COUNTY_VASTMANLAND,
        73 => Id::COUNTY_KOPPARBERG,
        74 => Id::COUNTY_UNDEFINED,
        77 => Id::COUNTY_GAVLEBORG,
        81 => Id::COUNTY_VASTERNORRLAND,
        84 => Id::COUNTY_JAMTLAND,
        88 => Id::COUNTY_VASTERBOTTEN,
        92 => Id::COUNTY_NORRBOTTEN
    ];

    /**
     * @var DateTime Date of birth
     */
    private $date;

    /**
     * Set id
     *
     * Format is YYYYMMDD(+-)NNNC or YYMMDD(+-)NNNC where parenthesis represents
     * an optional one char delimiter, N represents the individual number and C
     * the check digit. If year is set using two digits century is calculated
     * based on delimiter (+ signals more than a hundred years old). If year is
     * set using four digits delimiter is calculated based on century.
     *
     * @param  string $number
     * @throws Exception\InvalidDateStructureException If date is not logically valid
     */
    public function __construct($number)
    {
        list(, $century, $this->serialPre, $delimiter, $this->serialPost, $this->checkDigit)
            = PersonalId::parseStructure($number);

        $this->delimiter = $delimiter ?: '-';

        if ($century) {
            // Set delimiter based on date (+ if date is more then a hundred years old)
            $this->date = DateTimeCreator::createFromFormat('Ymd', $century.$this->serialPre);
            $hundredYearsAgo = new \DateTime();
            $hundredYearsAgo->modify('-100 year');
            $this->delimiter = $this->getDate() < $hundredYearsAgo ? '+' : '-';
        } else {
            // No century defined
            $this->date = DateTimeCreator::createFromFormat('ymd', $this->serialPre);
            
            // If in the future century is wrong
            if ($this->date > new \DateTime) {
                $this->date->modify('-100 year');
            }

            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $this->date->modify('-100 year');
            }
        }

        // Validate that date is logically valid
        if ($this->date->format('ymd') != $this->serialPre) {
            throw new Exception\InvalidDateStructureException("Invalid date in <{$this->getId()}>");
        }

        $this->validateCheckDigit();
    }

    /**
     * Get date of birth
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get sex as denoted by id
     *
     * @return string One of the sex identifier constants
     */
    public function getSex()
    {
        return (intval($this->getSerialPostDelimiter()[2])%2 == 0) ? self::SEX_FEMALE : self::SEX_MALE;
    }

    /**
     * Get string describing birth county
     *
     * @return string One of the birth county identifier constants
     */
    public function getBirthCounty()
    {
        if ($this->getDate() < DateTimeCreator::createFromFormat('Ymd', '19900101')) {
            $countyNr = (int) substr($this->getSerialPostDelimiter(), 0, 2);
            foreach (self::$birthCountyMap as $limit => $identifier) {
                if ($countyNr <= $limit) {
                    return $identifier;
                }
            }
        }

        return Id::COUNTY_UNDEFINED;
    }
}
