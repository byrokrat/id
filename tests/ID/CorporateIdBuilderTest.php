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

namespace iio\stb\ID;

class CorporateIdBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCorporateId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->disablePersonalId()
            ->disableCoordinationId()
            ->setId('702001-7781')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\CorporateId', $id);
    }

    public function testPersonalId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->enablePersonalId()
            ->disableCoordinationId()
            ->setId('820323-2775')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\PersonalId', $id);
    }

    public function testCoordinationId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->disablePersonalId()
            ->enableCoordinationId()
            ->setId('701063-2391')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\CoordinationId', $id);
    }

    public function testCoordinationIdWhenInvalidPersonalId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->enablePersonalId()
            ->enableCoordinationId()
            ->setId('701063-2391')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\CoordinationId', $id);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidPersonalIdError()
    {
        $builder = new CorporateIdBuilder();
        $builder->enablePersonalId()
            ->disableCoordinationId()
            ->setId('820383-2775')
            ->getId();
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidCorporateStructureError()
    {
        $builder = new CorporateIdBuilder();
        $builder->disablePersonalId()
            ->disableCoordinationId()
            ->setId('820383-2775') // Invalid structure
            ->getId();
    }

    public function testAll()
    {
        $builder = new CorporateIdBuilder();
        $builder->enablePersonalId()
                ->enableCoordinationId();

        $id = $builder->setId('702001-7781')->getId();
        $this->assertInstanceOf('\iio\stb\ID\CorporateId', $id);

        $id = $builder->setId('820323-2775')->getId();
        $this->assertInstanceOf('\iio\stb\ID\PersonalId', $id);

        $id = $builder->setId('701063-2391')->getId();
        $this->assertInstanceOf('\iio\stb\ID\CoordinationId', $id);
    }
}
