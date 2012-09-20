<?php
namespace itbz\STB\Banking;


class AccountBuilderTest extends \PHPUnit_Framework_TestCase
{

    function testNordeaPerson()
    {
        $builder = new AccountBuilder();
        $account = $builder->setAccount('3300,1111111116')
                           ->clearClasses()
                           ->enable('NordeaPerson')
                           ->getAccount();
        $this->assertInstanceOf("itbz\\STB\\Banking\\NordeaPerson", $account);
    }


    /**
     * @expectedException itbz\STB\Exception
     */
    function testClassMissingError()
    {
        $builder = new AccountBuilder();
        $account = $builder->setAccount('3300,1111111116')
                           ->disable('NordeaPerson')
                           ->getAccount();
    }

}
