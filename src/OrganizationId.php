<?php

namespace byrokrat\id;

/**
 * Swedish organizational identity numbers
 */
class OrganizationId implements Id
{
    use Component\Structure, Component\BaseImplementation, Component\BirthCounty;

    /**
     * @var string Regular expression describing structure
     */
    protected static $structure = '/^(\d{6})[-]?(\d{3})(\d)$/';

    /**
     * @var string[] Map of group number to legal form identifier
     */
    static private $legalFormMap = [
        0 => self::LEGAL_FORM_UNDEFINED,
        1 => self::LEGAL_FORM_UNDEFINED,
        2 => self::LEGAL_FORM_STATE_PARISH,
        3 => self::LEGAL_FORM_UNDEFINED,
        4 => self::LEGAL_FORM_UNDEFINED,
        5 => self::LEGAL_FORM_INCORPORATED,
        6 => self::LEGAL_FORM_PARTNERSHIP,
        7 => self::LEGAL_FORM_ASSOCIATION,
        8 => self::LEGAL_FORM_NONPROFIT,
        9 => self::LEGAL_FORM_TRADING
    ];

    /**
     * Set id number
     *
     * @param  string $number
     * @throws Exception\InvalidStructureException If structure is invalid
     */
    public function __construct($number)
    {
        list(, $this->serialPre, $this->serialPost, $this->checkDigit) = OrganizationId::parseStructure($number);

        if ($this->serialPre[2] < 2) {
            throw new Exception\InvalidStructureException('Third digit must be at lest 2');
        }

        $this->validateCheckDigit();
    }

    /**
     * Get string describing legal form
     *
     * NOTE: this is just a hint and does not conclusively determine the legal
     * status of the organization.
     *
     * @return string One of the legal form identifier constants
     */
    public function getLegalForm()
    {
        return self::$legalFormMap[$this->getSerialPreDelimiter()[0]];
    }
}
