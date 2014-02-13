# ledgr/id [![Code Coverage](https://scrutinizer-ci.com/g/ledgr/id/badges/coverage.png?s=7a9fefd7d6535b32d2d97be1a9e583535391dd33)](https://scrutinizer-ci.com/g/ledgr/id/)


Data types for swedish social security and corporation id numbers.

**License**: [GPL](/LICENSE)


Installation using [composer](http://getcomposer.org/)
------------------------------------------------------
Simply add `ledgr/id` to your list of required libraries.


Usage
-----
Personal id is presented here as an example of what you can do with the id objects.

    use ledgr\id\PersonalId;
    $id = new PersonalId('820323-2775');
    echo $id->getId();                      //820323-2775
    echo $id->getLondId();                  //19820323-2775
    echo $id->getDate()->format('Y-m-d');   //1982-03-23
    echo $id->getSex();                     //M

### Creating ID objects

Creating ID objects can be comlicated.

* A personal id can be a coordination id, if the personal identified as not a
swedish citicen.
* A corporation id can be a personal id if the corporation is registered with a
single individual (egenföretagare).
* A single individual company can use a coordination id if the individual is
not a swedish citicen.
* At times you may wish to process persons without a valid swedish personal id,
using the FakeId implementation.

To solve these difficulties a decoratable IdFactory is included. Create a factory
with the abilities you need by chaining factory objects at creation time.

    $factory = new PersonalIdFactory(new CoordinationIdFactory());
    $id = $factory->create('some id...');

In this example the factory will first try to create a PersonalId, if this fails
it will try to create a CoordinationId, if this fails it will throw an Exception.


Run tests  using [phpunit](http://phpunit.de/)
----------------------------------------------
To run the tests you must first install dependencies using composer.

    $ curl -sS https://getcomposer.org/installer | php
    $ php composer.phar install
    $ phpunit
