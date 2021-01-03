<?php

namespace byrokrat\id;

/**
 * Collection of county identifiers
 */
interface Counties
{
    /**
     * Maps county number high limit to county identifier
     */
    public const COUNTY_NUMBER_MAP = [
        13 => self::COUNTY_STOCKHOLM,
        15 => self::COUNTY_UPPSALA,
        18 => self::COUNTY_SODERMANLAND,
        23 => self::COUNTY_OSTERGOTLAND,
        26 => self::COUNTY_JONKOPING,
        28 => self::COUNTY_KRONOBERG,
        31 => self::COUNTY_KALMAR,
        32 => self::COUNTY_GOTLAND,
        34 => self::COUNTY_BLEKINGE,
        38 => self::COUNTY_KRISTIANSTAD,
        45 => self::COUNTY_MALMOHUS,
        47 => self::COUNTY_HALLAND,
        54 => self::COUNTY_GOTEBORG_BOUHUS,
        58 => self::COUNTY_ALVSBORG,
        61 => self::COUNTY_SKARABORG,
        64 => self::COUNTY_VARMLAND,
        65 => self::COUNTY_UNDEFINED,
        68 => self::COUNTY_OREBRO,
        70 => self::COUNTY_VASTMANLAND,
        73 => self::COUNTY_KOPPARBERG,
        74 => self::COUNTY_UNDEFINED,
        77 => self::COUNTY_GAVLEBORG,
        81 => self::COUNTY_VASTERNORRLAND,
        84 => self::COUNTY_JAMTLAND,
        88 => self::COUNTY_VASTERBOTTEN,
        92 => self::COUNTY_NORRBOTTEN,
    ];

    /**
     * Undefined county identifier
     */
    public const COUNTY_UNDEFINED = '';

    /**
     * Stockholms county identifier
     */
    public const COUNTY_STOCKHOLM = 'Stockholms stad';

    /**
     * Uppsala county identifier
     */
    public const COUNTY_UPPSALA = 'Uppsala län';

    /**
     * Södermanlands county identifier
     */
    public const COUNTY_SODERMANLAND = 'Södermanlands län';

    /**
     * Östergötlands county identifier
     */
    public const COUNTY_OSTERGOTLAND = 'Östergötlands län';

    /**
     * Jönköpings county identifier
     */
    public const COUNTY_JONKOPING = 'Jönköpings län';

    /**
     * Kronobergs county identifier
     */
    public const COUNTY_KRONOBERG = 'Kronobergs län';

    /**
     * Kalmar county identifier
     */
    public const COUNTY_KALMAR = 'Kalmar län';

    /**
     * Gotlands county identifier
     */
    public const COUNTY_GOTLAND = 'Gotlands län';

    /**
     * Blekinge county identifier
     */
    public const COUNTY_BLEKINGE = 'Blekinge län';

    /**
     * Kristianstads county identifier
     */
    public const COUNTY_KRISTIANSTAD = 'Kristianstads län';

    /**
     * Malmöhus county identifier
     */
    public const COUNTY_MALMOHUS = 'Malmöhus län';

    /**
     * Hallands county identifier
     */
    public const COUNTY_HALLAND = 'Hallands län';

    /**
     * Göteborgs and Bohus county identifier
     */
    public const COUNTY_GOTEBORG_BOUHUS = 'Göteborgs och Bohus län';

    /**
     * Älvsborgs county identifier
     */
    public const COUNTY_ALVSBORG = 'Älvsborgs län';

    /**
     * Skaraborgs county identifier
     */
    public const COUNTY_SKARABORG = 'Skaraborgs län';

    /**
     * Värmlands county identifier
     */
    public const COUNTY_VARMLAND = 'Värmlands län';

    /**
     * Örebro county identifier
     */
    public const COUNTY_OREBRO = 'Örebro län';

    /**
     * Västmanlands county identifier
     */
    public const COUNTY_VASTMANLAND = 'Västmanlands län';

    /**
     * Kopparbergs county identifier
     */
    public const COUNTY_KOPPARBERG = 'Kopparbergs län';

    /**
     * Gävleborgs county identifier
     */
    public const COUNTY_GAVLEBORG = 'Gävleborgs län';

    /**
     * Västernorrlands county identifier
     */
    public const COUNTY_VASTERNORRLAND = 'Västernorrlands län';

    /**
     * Jämtlands county identifier
     */
    public const COUNTY_JAMTLAND = 'Jämtlands län';

    /**
     * Västerbottens county identifier
     */
    public const COUNTY_VASTERBOTTEN = 'Västerbottens län';

    /**
     * Norrbottens county identifier
     */
    public const COUNTY_NORRBOTTEN = 'Norrbottens län';
}
