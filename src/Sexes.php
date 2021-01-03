<?php

namespace byrokrat\id;

/**
 * Collection of sex identifiers
 */
interface Sexes
{
    /**
     * Female sex identifier
     */
    public const SEX_FEMALE = 'F';

    /**
     * Male sex identifier
     */
    public const SEX_MALE = 'M';

    /**
     * Other sex identifier
     */
    public const SEX_OTHER = 'O';

    /**
     * Undefined sex identifier
     */
    public const SEX_UNDEFINED = 'X';
}
