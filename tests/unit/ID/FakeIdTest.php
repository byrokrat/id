<?php
namespace itbz\STB\ID;

class FakeIdTest extends \PHPUnit_Framework_TestCase
{
    public function invalidStructureProvider()
    {
        return array(
            array('123456'),
            array('123456-'),
            array('-1234'),
            array('123456-123'),
            array('123456-12345'),
            array('1234567-1234'),
            array('1234567-1234'),
            array('123456-1A34'),
            array('12A456-1234'),
            array('123456-xxxx'),
            array('123456+'),
            array('+1234'),
            array('123456+123'),
            array('123456+12345'),
            array('1234567+1234'),
            array('1234567+1234'),
            array('123456+1A34'),
            array('12A456+1234'),
            array('123456+xxxx'),

            array('123456-1234'),
            array('123456+1234'),
            array('820323-2775'),
            array('820323+2775'),
        );
    }

    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    public function testInvalidStructure($nr)
    {
        new FakeId($nr);
    }

    public function testCentry()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('1982', $id->getDate()->format('Y'));

        $id = new FakeId('820323+xxxx');
        $this->assertEquals('1882', $id->getDate()->format('Y'));
    }

    public function testDelimiter()
    {
        $id = new FakeId('19820323+xx1x');
        $this->assertEquals('820323-xx1x', $id->getId());

        $id = new FakeId('18820323-xx2x');
        $this->assertEquals('820323+xx2x', $id->getId());
    }

    public function testSex()
    {
        $id = new FakeId('820323-xx1x');
        $this->assertEquals('M', $id->getSex());

        $id = new FakeId('770314-xx2x');
        $this->assertEquals('F', $id->getSex());

        $id = new FakeId('770314-xxxx');
        $this->assertEquals('O', $id->getSex());
    }

    public function testDOB()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('1982-03-23', $id->getDOB());
    }

    public function testToString()
    {
        $id = new FakeId('820323-xxxx');
        $this->assertEquals('19820323-xxxx', (string)$id);
    }
}
