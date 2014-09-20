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
     * @param string $id
     */
    public function __construct($id)
    {
        list(, $century, $this->serialPre, $delimiter, $this->serialPost, $this->checkDigit) = PersonalId::parseStructure($id);

        $this->delimiter = $delimiter ?: '-';

        if ($century) {
            // Set delimiter based on date (+ if date is more then a hundred years old)
            $this->date = DateTime::createFromFormat('Ymd', $century.$this->serialPre);
            $hundredYearsAgo = new DateTime();
            $hundredYearsAgo->modify('-100 year');
            $this->delimiter = $this->getDate() < $hundredYearsAgo ? '+' : '-';
        } else {
            // No century defined
            $this->date = DateTime::createFromFormat('ymd', $this->serialPre);
            
            // If in the future century is wrong
            if ($this->date > new DateTime) {
                $this->date->modify('-100 year');
            }

            // Date is over a hundred years ago if delimiter is +
            if ($this->getDelimiter() == '+') {
                $this->date->modify('-100 year');
            }
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
}
