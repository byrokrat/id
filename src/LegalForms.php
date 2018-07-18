<?php

namespace byrokrat\id;

/**
 * Collection of legal form identifiers
 */
interface LegalForms
{
    /**
     * Undefined legal form identifier
     */
    const LEGAL_FORM_UNDEFINED = '';

    /**
     * State, county, municipality or parish legal form identifier
     */
    const LEGAL_FORM_STATE_PARISH = 'Stat, landsting, kommun eller församling';

    /**
     * Incorporated company legal form identifier
     */
    const LEGAL_FORM_INCORPORATED = 'Aktiebolag';

    /**
     * Partnership legal form identifier
     */
    const LEGAL_FORM_PARTNERSHIP = 'Enkelt bolag';

    /**
     * Economic association legal form identifier
     */
    const LEGAL_FORM_ASSOCIATION = 'Ekonomisk förening';

    /**
     * Non-profit organization or foundation legal form identifier
     */
    const LEGAL_FORM_NONPROFIT = 'Ideell förening eller stiftelse';

    /**
     * Trading company, limited partnership or partnership legal form identifier
     */
    const LEGAL_FORM_TRADING = 'Handelsbolag, kommanditbolag eller enkelt bolag';
}
