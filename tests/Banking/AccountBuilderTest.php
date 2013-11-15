<?php
namespace iio\stb\Banking;

class AccountBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testNordeaPerson()
    {
        $builder = new AccountBuilder();
        $account = $builder->setAccount('3300,1111111116')
            ->clearClasses()
            ->enable('NordeaPerson')
            ->getAccount();
        $this->assertInstanceOf("iio\\stb\\Banking\\NordeaPerson", $account);
    }

    /**
     * @expectedException iio\stb\Exception
     */
    public function testClassMissingError()
    {
        $builder = new AccountBuilder();
        $builder->setAccount('3300,1111111116')
            ->disable('NordeaPerson')
            ->disable('FakeAccount')
            ->getAccount();
    }
}
