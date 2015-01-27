<?php

namespace byrokrat\id;

/**
 * Null object implementation of the Id interface
 */
class NullId implements Id
{
    use Component\BaseImplementation, Component\BirthCounty;

    /**
     * @var string String returned by getId()
     */
    private static $str = '-';

    /**
     * Set string returned by getId()
     *
     * @param  string $str
     * @return void
     */
    public static function setString($str)
    {
        self::$str = $str;
    }

    /**
     * Get id as set using setString()
     *
     * @return string
     */
    public function getId()
    {
        return self::$str;
    }
}
