<?php
namespace itbz\STB\ID;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class PersonalIdBuilderTest extends \PHPUnit_Framework_TestCase
{

    function testPersonalId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->disableFakeId()
                      ->disableCoordinationId()
                      ->setId('820323-2775')
                      ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\PersonalId', $id);
    }


    function testCoordinationId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->disableFakeId()
                      ->enableCoordinationId()
                      ->setId('701063-2391')
                      ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\CoordinationId', $id);
    }


    function testFakeId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->enableFakeId()
                      ->disableCoordinationId()
                      ->setId('701023-xxxx')
                      ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\FakeId', $id);
    }


    function testFakeIdWhenInvalidCoordinationId()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->enableFakeId()
                      ->enableCoordinationId()
                      ->setId('701023-xxxx')
                      ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\FakeId', $id);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidCoordinationStructureError()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->disableFakeId()
                      ->enableCoordinationId()
                      ->setId('701023-xxxx') // Invalid structure
                      ->getId();
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     */
    function testInvalidPersonalIdStructureError()
    {
        $builder = new PersonalIdBuilder();
        $id = $builder->disableFakeId()
                      ->disableCoordinationId()
                      ->setId('820383-2775')
                      ->getId();
    }


    function testAll()
    {
        $builder = new PersonalIdBuilder();
        $builder->enableFakeId()
                ->enableCoordinationId();

        $id = $builder->setId('820323-2775')->getId();
        $this->assertInstanceOf('\itbz\STB\ID\PersonalId', $id);

        $id = $builder->setId('701063-2391')->getId();
        $this->assertInstanceOf('\itbz\STB\ID\CoordinationId', $id);

        $id = $builder->setId('701023-xxxx')->getId();
        $this->assertInstanceOf('\itbz\STB\ID\FakeId', $id);
    }

}
