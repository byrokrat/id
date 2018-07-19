<?php

declare(strict_types = 1);

namespace byrokrat\id;

use byrokrat\id\Helper\AbstractId;
use byrokrat\id\Helper\Modulo10;

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
     * Maps group numbers to legal form identifiers
     */
    private const LEGAL_FORM_MAP = [
        0 => LegalForms::LEGAL_FORM_UNDEFINED,
        1 => LegalForms::LEGAL_FORM_UNDEFINED,
        2 => LegalForms::LEGAL_FORM_STATE_PARISH,
        3 => LegalForms::LEGAL_FORM_UNDEFINED,
        4 => LegalForms::LEGAL_FORM_UNDEFINED,
        5 => LegalForms::LEGAL_FORM_INCORPORATED,
        6 => LegalForms::LEGAL_FORM_PARTNERSHIP,
        7 => LegalForms::LEGAL_FORM_ASSOCIATION,
        8 => LegalForms::LEGAL_FORM_NONPROFIT,
        9 => LegalForms::LEGAL_FORM_TRADING,
    ];

    /**
     * Set organization id number
     *
     * @throws Exception\InvalidStructureException If structure is invalid
     */
    public function __construct(string $number)
    {
        list(, $this->serialPre, $this->serialPost, $this->checkDigit) = $this->parseNumber(self::PATTERN, $number);

        if ($this->serialPre[2] < 2) {
            throw new Exception\InvalidStructureException('Third digit must be at lest 2');
        }

        Modulo10::validateCheckDigit($this);
    }

    public function getLegalForm(): string
    {
        return self::LEGAL_FORM_MAP[$this->getSerialPreDelimiter()[0]];
    }
}
