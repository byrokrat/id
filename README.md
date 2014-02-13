Swedish Technical Bureaucracy (STB)
===================================


Installation using composer
---------------------------
The usage of [composer](http://getcomposer.org/) is recommended. Simply add
`iio/stb` to your list of required libraries.


ID
--
Data types for swedish social security and corporation id numbers.

### PersonalId

Personal id is presented here as an example of what you can do with the id objects.

    use iio\stb\ID\PersonalId;
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


Running unit tests
------------------
From project root simply type

    > phpunit
