<?php

declare(strict_types = 1);

namespace byrokrat\id\skatteverket;

use PHPUnit\Framework\TestCase;

/**
 * @implements \IteratorAggregate<string>
 */
class TestdataProvider implements \IteratorAggregate
{
    /**
     * @var string
     */
    private $dirname;

    public function __construct(string $dirname)
    {
        $this->dirname = $dirname;
    }

    /**
     * @return iterable<string>
     */
    public function getIterator(): iterable
    {
        foreach (glob($this->dirname . '/*.csv') as $fname) {
            $handle = fopen($fname, "r");

            if ($handle) {
                fgets($handle);

                while (($line = fgets($handle)) !== false) {
                    yield [$line];
                }

                fclose($handle);
            }
        }
    }
}
