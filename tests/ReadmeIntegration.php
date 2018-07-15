<?php

declare(strict_types = 1);

namespace byrokrat\id;

use hanneskod\readmetester\PHPUnit\AssertReadme;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class ReadmeIntegration extends TestCase
{
    public function testReadmeIntegrationTests()
    {
        if (!class_exists('hanneskod\readmetester\PHPUnit\AssertReadme')) {
            return $this->markTestSkipped('Readme-tester is not available.');
        }

        (new AssertReadme($this))->assertReadme('README.md');
    }
}
