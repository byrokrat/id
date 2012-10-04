<?php
namespace itbz\STB\ID;

class CorporateIdBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testCorporateId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->disablePersonalId()
            ->disableCoordinationId()
            ->setId('702001-7781')
            ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\CorporateId', $id);
    }

    public function testPersonalId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->enablePersonalId()
            ->disableCoordinationId()
            ->setId('820323-2775')
            ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\PersonalId', $id);
    }

    public function testCoordinationId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->disablePersonalId()
            ->enableCoordinationId()
            ->setId('701063-2391')
            ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\CoordinationId', $id);
    }

    public function testCoordinationIdWhenInvalidPersonalId()
    {
        $builder = new CorporateIdBuilder();
        $id = $builder->enablePersonalId()
            ->enableCoordinationId()
            ->setId('701063-2391')
            ->getId();
        $this->assertInstanceOf('\itbz\STB\ID\CoordinationId', $id);
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     */
    public function testInvalidPersonalIdStructureError()
    {
        $builder = new CorporateIdBuilder();
        $builder->enablePersonalId()
            ->disableCoordinationId()
            ->setId('820383-2775')
            ->getId();
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
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
        $this->assertInstanceOf('\itbz\STB\ID\CorporateId', $id);

        $id = $builder->setId('820323-2775')->getId();
        $this->assertInstanceOf('\itbz\STB\ID\PersonalId', $id);

        $id = $builder->setId('701063-2391')->getId();
        $this->assertInstanceOf('\itbz\STB\ID\CoordinationId', $id);
    }
}
