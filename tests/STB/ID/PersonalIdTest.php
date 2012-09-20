<?php
namespace itbz\STB\ID;


class PersonalIdTest extends \PHPUnit_Framework_TestCase
{

    function invalidStructureProvider()
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
            array('123456-1234'),
            array('123456+'),
            array('+1234'),
            array('123456+123'),
            array('123456+12345'),
            array('1234567+1234'),
            array('1234567+1234'),
            array('123456+1A34'),
            array('12A456+1234'),
            array('123456+1234'),
            array('120101-A234'),
            array('120101-12345'),
            array('120101+A234'),
            array('120101+12345'),
        );
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('820323-2770'),
            array('820323-2771'),
            array('820323-2772'),
            array('820323-2773'),
            array('820323-2774'),
            array('820323-2776'),
            array('820323-2777'),
            array('820323-2778'),
            array('820323-2779'),
            array('820323+2770'),
            array('820323+2771'),
            array('820323+2772'),
            array('820323+2773'),
            array('820323+2774'),
            array('820323+2776'),
            array('820323+2777'),
            array('820323+2778'),
            array('820323+2779'),
        );
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    function testInvalidStructure($nr)
    { 
        $id = new PersonalId($nr);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    function testInvalidCheckDigit($nr)
    {
        $id = new PersonalId($nr);
    }


    function testCentry()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('1982', $id->getDate()->format('Y'));

        $id = new PersonalId('820323+2775');
        $this->assertEquals('1882', $id->getDate()->format('Y'));
    }

    
    function testDelimiter()
    {
        $id = new PersonalId('19820323+2775');
        $this->assertEquals('820323-2775', $id->getId());

        $id = new PersonalId('18820323-2775');
        $this->assertEquals('820323+2775', $id->getId());
    }


    function testSex()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('M', $id->getSex());

        $id = new PersonalId('770314-0348');
        $this->assertEquals('F', $id->getSex());
    }


    function testDOB()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('1982-03-23', $id->getDOB());

        $id = new PersonalId('19820323-2775');
        $this->assertEquals('1982-03-23', $id->getDOB());
    }


    function testToString()
    {
        $id = new PersonalId('820323-2775');
        $this->assertEquals('19820323-2775', (string)$id);
    }

}
