<?php
namespace itbz\STB\ID;


// Using the mreg autoloader for now...
require_once __DIR__ . "/../../../../../libs/autoload.php";


class CoordinationIdTest extends \PHPUnit_Framework_TestCase
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
            array('123456+'),
            array('+1234'),
            array('123456+123'),
            array('123456+12345'),
            array('1234567+1234'),
            array('1234567+1234'),
            array('123456+1A34'),
            array('12A456+1234'),
        );
    }


    function invalidCheckDigitProvider()
    {
        return array(
            array('820383-2770'),
            array('820383-2771'),
            array('820383-2775'),
            array('820383-2773'),
            array('820383-2774'),
            array('820383-2776'),
            array('820383-2777'),
            array('820383-2778'),
            array('820383-2779'),
            array('820383+2770'),
            array('820383+2771'),
            array('820383+2775'),
            array('820383+2773'),
            array('820383+2774'),
            array('820383+2776'),
            array('820383+2777'),
            array('820383+2778'),
            array('820383+2779'),
        );
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidStructureException
     * @dataProvider invalidStructureProvider
     */
    function testInvalidStructure($nr)
    { 
        $id = new CoordinationId($nr);
    }


    /**
     * @expectedException itbz\STB\Exception\InvalidCheckDigitException
     * @dataProvider invalidCheckDigitProvider
     */
    function testInvalidCheckDigit($nr)
    {
        $id = new CoordinationId($nr);
    }


    function testCentry()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('1970', $id->getDate()->format('Y'));

        $id = new CoordinationId('701063+2391');
        $this->assertEquals('1870', $id->getDate()->format('Y'));
    }

    
    function testDelimiter()
    {
        $id = new CoordinationId('19701063+2391');
        $this->assertEquals('701063-2391', $id->getId());

        $id = new CoordinationId('18701063-2391');
        $this->assertEquals('701063+2391', $id->getId());
    }


    function testSex()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('M', $id->getSex());

        $id = new CoordinationId('770374-0345');
        $this->assertEquals('F', $id->getSex());
    }


    function testDOB()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('1970-10-03', $id->getDOB());
    }


    function testToString()
    {
        $id = new CoordinationId('701063-2391');
        $this->assertEquals('19701063-2391', (string)$id);
    }

}
