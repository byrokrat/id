<?php

namespace byrokrat\id\Exception;

/**
 * Represent errors in the program logic, this kind of exception should lead directly to a fix in your code
 */
class LogicException extends \LogicException implements \byrokrat\id\Exception
{
}
