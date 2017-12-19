<?php

namespace byrokrat\id;

/**
 * Swedish organizational identity numbers
 */
class OrganizationId extends AbstractId
{
    /**
     * Regular expression describing id structure
     */
    const PATTERN = '/^(\d{6})[-]?(\d{3})(\d)$/';

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
     * Set organization id number
     *
     * @param  string $number
     * @throws Exception\InvalidStructureException If structure is invalid
     */
    public function __construct($number)
    {
        list(, $this->serialPre, $this->serialPost, $this->checkDigit) = $this->parseNumber(self::PATTERN, $number);

        if ($this->serialPre[2] < 2) {
            throw new Exception\InvalidStructureException('Third digit must be at lest 2');
        }

        $this->validateCheckDigit();
    }

    public function getLegalForm()
    {
        return self::$legalFormMap[$this->getSerialPreDelimiter()[0]];
    }
}
