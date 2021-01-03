<?php

declare(strict_types=1);

namespace byrokrat\id;

class NullIdFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateId()
    {
        $this->assertInstanceOf(
            NullId::CLASS,
            (new NullIdFactory())->createId('')
        );
    }
}
