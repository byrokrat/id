<?php
/**
 * This file is part of Swedish-Technical-Bureaucracy.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * Swedish-Technical-Bureaucracy is free software: you can redistribute it
 * and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the License,
 * or (at your option) any later version.
 *
 * Swedish-Technical-Bureaucracy is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Swedish-Technical-Bureaucracy.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace iio\stb\Banking;

class StaticBankAccountFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        StaticBankAccountFactory::clearClasses();
        StaticBankAccountFactory::enable('NordeaPerson');
        $account = StaticBankAccountFactory::build('3300,1111111116');
        $this->assertInstanceOf(
            "iio\\stb\\Banking\\NordeaPerson",
            $account
        );
    }

    /**
     * @expectedException iio\stb\Exception
     */
    public function testClassMissingError()
    {
        StaticBankAccountFactory::disable('NordeaPerson');
        StaticBankAccountFactory::build('3300,1111111116');
    }
}
