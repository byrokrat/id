<?php

declare(strict_types = 1);

namespace byrokrat\id;

class FailingIdFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testExceptionOnCreateId()
    {
        $this->expectException(Exception\UnableToCreateIdException::CLASS);
        (new FailingIdFactory)->createId('');
    }
}
