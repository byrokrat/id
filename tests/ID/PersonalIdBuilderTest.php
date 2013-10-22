<?php
namespace iio\stb\ID;

class PersonalIdBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testPersonalId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->disableFakeId()
            ->disableCoordinationId()
            ->setId('820323-2775')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\PersonalId', $id);
    }

    public function testCoordinationId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->disableFakeId()
            ->enableCoordinationId()
            ->setId('701063-2391')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\CoordinationId', $id);
    }

    public function testFakeId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->enableFakeId()
            ->disableCoordinationId()
            ->setId('701023-xxxx')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\FakeId', $id);
    }

    public function testFakeIdWhenInvalidCoordinationId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->enableFakeId()
            ->enableCoordinationId()
            ->setId('701023-xxxx')
            ->getId();
        $this->assertInstanceOf('\iio\stb\ID\FakeId', $id);
    }

    /**
     * @expectedException iio\stb\Exception\InvalidStructureException
     */
    public function testInvalidCoordinationStructureError()
    {
        $builder = new PersonalIdBuilder();
        $builder->disableFakeId()
            ->enableCoordinationId()
            ->setId('701023-xxxx') // Invalid structure
            ->getId();
    }

    /**
     * @expectedException iio\stb\Exception\InvalidCheckDigitException
     */
    public function testInvalidPersonalIdError()
    {
        $builder = new PersonalIdBuilder();
        $builder->disableFakeId()
            ->disableCoordinationId()
            ->setId('820383-2775')
            ->getId();
    }

    public function testAll()
    {
        $builder = new PersonalIdBuilder();
        $builder->enableFakeId()
            ->enableCoordinationId();

        $id = $builder->setId('820323-2775')->getId();
        $this->assertInstanceOf('\iio\stb\ID\PersonalId', $id);

        $id = $builder->setId('701063-2391')->getId();
        $this->assertInstanceOf('\iio\stb\ID\CoordinationId', $id);

        $id = $builder->setId('701023-xxxx')->getId();
        $this->assertInstanceOf('\iio\stb\ID\FakeId', $id);
    }
}
