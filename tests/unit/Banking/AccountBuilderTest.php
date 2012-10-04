<?php
namespace itbz\STB\Banking;

class AccountBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testNordeaPerson()
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
    public function testClassMissingError()
    {
        $builder = new AccountBuilder();
        $builder->setAccount('3300,1111111116')
            ->disable('NordeaPerson')
            ->getAccount();
    }
}
