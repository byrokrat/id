<?php

declare(strict_types = 1);

namespace byrokrat\id;

/**
 * Null object implementation of the Id interface
 */
class NullId implements IdInterface
{
    use Helper\BasicIdTrait;

    /**
     * @var string
     */
    private static $str = '-';

    /**
     * Set string returned by getId()
     */
    public static function setString(string $str): void
    {
        self::$str = $str;
    }

    public function getId(): string
    {
        return self::$str;
    }
}
