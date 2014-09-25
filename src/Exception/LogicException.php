<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\id\Exception;

/**
 * Represent errors in the program logic, this kind of exception should lead directly to a fix in your code
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class LogicException extends \LogicException implements \ledgr\id\Exception
{
}
