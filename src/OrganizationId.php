<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\BasicIdTrait;
use byrokrat\id\Helper\Modulo10;
use byrokrat\id\Helper\NumberParser;
use byrokrat\id\Exception\UnableToCreateIdException;

class OrganizationId implements IdInterface
{
    use BasicIdTrait;

    /**
     * Regular expression describing id structure
     */
    private const PATTERN = '/^(\d{2}[2-9]\d{3})[-]?(\d{3})(\d)$/';

    /**
     * Create organizational identity number
     *
     * @throws UnableToCreateIdException On failure to create id
     */
    public function __construct(string $number)
    {
        list($this->serialPre, $this->serialPost, $this->checkDigit) = NumberParser::parse(self::PATTERN, $number);

        Modulo10::validateCheckDigit($this);
    }

    public function getLegalForm(): string
    {
        return LegalForms::LEGAL_FORM_MAP[$this->getSerialPreDelimiter()[0]] ?? LegalForms::LEGAL_FORM_UNDEFINED;
    }
}
