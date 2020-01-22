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
    const COUNTY_NUMBER_MAP = [
        13 => Counties::COUNTY_STOCKHOLM,
        15 => Counties::COUNTY_UPPSALA,
        18 => Counties::COUNTY_SODERMANLAND,
        23 => Counties::COUNTY_OSTERGOTLAND,
        26 => Counties::COUNTY_JONKOPING,
        28 => Counties::COUNTY_KRONOBERG,
        31 => Counties::COUNTY_KALMAR,
        32 => Counties::COUNTY_GOTLAND,
        34 => Counties::COUNTY_BLEKINGE,
        38 => Counties::COUNTY_KRISTIANSTAD,
        45 => Counties::COUNTY_MALMOHUS,
        47 => Counties::COUNTY_HALLAND,
        54 => Counties::COUNTY_GOTEBORG_BOUHUS,
        58 => Counties::COUNTY_ALVSBORG,
        61 => Counties::COUNTY_SKARABORG,
        64 => Counties::COUNTY_VARMLAND,
        65 => Counties::COUNTY_UNDEFINED,
        68 => Counties::COUNTY_OREBRO,
        70 => Counties::COUNTY_VASTMANLAND,
        73 => Counties::COUNTY_KOPPARBERG,
        74 => Counties::COUNTY_UNDEFINED,
        77 => Counties::COUNTY_GAVLEBORG,
        81 => Counties::COUNTY_VASTERNORRLAND,
        84 => Counties::COUNTY_JAMTLAND,
        88 => Counties::COUNTY_VASTERBOTTEN,
        92 => Counties::COUNTY_NORRBOTTEN,
    ];

    /**
     * Undefined county identifier
     */
    const COUNTY_UNDEFINED = '';

    /**
     * Stockholms county identifier
     */
    const COUNTY_STOCKHOLM = 'Stockholms stad';

    /**
     * Uppsala county identifier
     */
    const COUNTY_UPPSALA = 'Uppsala län';

    /**
     * Södermanlands county identifier
     */
    const COUNTY_SODERMANLAND = 'Södermanlands län';

    /**
     * Östergötlands county identifier
     */
    const COUNTY_OSTERGOTLAND = 'Östergötlands län';

    /**
     * Jönköpings county identifier
     */
    const COUNTY_JONKOPING = 'Jönköpings län';

    /**
     * Kronobergs county identifier
     */
    const COUNTY_KRONOBERG= 'Kronobergs län';

    /**
     * Kalmar county identifier
     */
    const COUNTY_KALMAR = 'Kalmar län';

    /**
     * Gotlands county identifier
     */
    const COUNTY_GOTLAND = 'Gotlands län';

    /**
     * Blekinge county identifier
     */
    const COUNTY_BLEKINGE = 'Blekinge län';

    /**
     * Kristianstads county identifier
     */
    const COUNTY_KRISTIANSTAD = 'Kristianstads län';

    /**
     * Malmöhus county identifier
     */
    const COUNTY_MALMOHUS = 'Malmöhus län';

    /**
     * Hallands county identifier
     */
    const COUNTY_HALLAND = 'Hallands län';

    /**
     * Göteborgs and Bohus county identifier
     */
    const COUNTY_GOTEBORG_BOUHUS = 'Göteborgs och Bohus län';

    /**
     * Älvsborgs county identifier
     */
    const COUNTY_ALVSBORG = 'Älvsborgs län';

    /**
     * Skaraborgs county identifier
     */
    const COUNTY_SKARABORG = 'Skaraborgs län';

    /**
     * Värmlands county identifier
     */
    const COUNTY_VARMLAND = 'Värmlands län';

    /**
     * Örebro county identifier
     */
    const COUNTY_OREBRO = 'Örebro län';

    /**
     * Västmanlands county identifier
     */
    const COUNTY_VASTMANLAND = 'Västmanlands län';

    /**
     * Kopparbergs county identifier
     */
    const COUNTY_KOPPARBERG = 'Kopparbergs län';

    /**
     * Gävleborgs county identifier
     */
    const COUNTY_GAVLEBORG = 'Gävleborgs län';

    /**
     * Västernorrlands county identifier
     */
    const COUNTY_VASTERNORRLAND = 'Västernorrlands län';

    /**
     * Jämtlands county identifier
     */
    const COUNTY_JAMTLAND = 'Jämtlands län';

    /**
     * Västerbottens county identifier
     */
    const COUNTY_VASTERBOTTEN = 'Västerbottens län';

    /**
     * Norrbottens county identifier
     */
    const COUNTY_NORRBOTTEN = 'Norrbottens län';
}
