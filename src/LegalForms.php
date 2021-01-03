<?php

namespace byrokrat\id;

/**
 * Collection of legal form identifiers
 */
interface LegalForms
{
    /**
     * Maps group number to legal form identifier
     */
    public const LEGAL_FORM_MAP = [
        0 => self::LEGAL_FORM_UNDEFINED,
        1 => self::LEGAL_FORM_UNDEFINED,
        2 => self::LEGAL_FORM_STATE_PARISH,
        3 => self::LEGAL_FORM_UNDEFINED,
        4 => self::LEGAL_FORM_UNDEFINED,
        5 => self::LEGAL_FORM_INCORPORATED,
        6 => self::LEGAL_FORM_PARTNERSHIP,
        7 => self::LEGAL_FORM_ASSOCIATION,
        8 => self::LEGAL_FORM_NONPROFIT,
        9 => self::LEGAL_FORM_TRADING,
    ];

    /**
     * Undefined legal form identifier
     */
    public const LEGAL_FORM_UNDEFINED = '';

    /**
     * State, county, municipality or parish legal form identifier
     */
    public const LEGAL_FORM_STATE_PARISH = 'Stat, landsting, kommun eller församling';

    /**
     * Incorporated company legal form identifier
     */
    public const LEGAL_FORM_INCORPORATED = 'Aktiebolag';

    /**
     * Partnership legal form identifier
     */
    public const LEGAL_FORM_PARTNERSHIP = 'Enkelt bolag';

    /**
     * Economic association legal form identifier
     */
    public const LEGAL_FORM_ASSOCIATION = 'Ekonomisk förening';

    /**
     * Non-profit organization or foundation legal form identifier
     */
    public const LEGAL_FORM_NONPROFIT = 'Ideell förening eller stiftelse';

    /**
     * Trading company, limited partnership or partnership legal form identifier
     */
    public const LEGAL_FORM_TRADING = 'Handelsbolag, kommanditbolag eller enkelt bolag';
}
