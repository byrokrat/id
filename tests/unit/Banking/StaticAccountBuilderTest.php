<?php
namespace iio\stb\Banking;

class StaticAccountBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        StaticAccountBuilder::clearClasses();
        StaticAccountBuilder::enable('NordeaPerson');
        $account = StaticAccountBuilder::build('3300,1111111116');
        $this->assertInstanceOf(
            "iio\\stb\\Banking\\NordeaPerson",
            $account
        );
    }

    /**
     * @expectedException iio\stb\Exception
     */
    public function testClassMissingError()
    {
        StaticAccountBuilder::disable('NordeaPerson');
        StaticAccountBuilder::build('3300,1111111116');
    }
}
