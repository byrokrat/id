# ledgr/id

[![Latest Stable Version](https://poser.pugx.org/ledgr/id/v/stable.png)](https://packagist.org/packages/ledgr/id)
[![Build Status](https://travis-ci.org/ledgr/id.png?branch=master)](https://travis-ci.org/ledgr/id)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ledgr/id/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ledgr/id/?branch=master)
[![Dependency Status](https://gemnasium.com/ledgr/id.png)](https://gemnasium.com/ledgr/id)

Data types for swedish social security and corporation id numbers

> Install using [composer](http://getcomposer.org/). Exists as **ledgr/id** in
> the packagist repository.


Usage
-----

```php
use ledgr\id\PersonalId;
$id = new PersonalId('820323-2775');
echo $id->getId();                      //820323-2775
echo $id->getLongId();                  //19820323-2775
echo $id->getDate()->format('Y-m-d');   //1982-03-23
echo $id->getSex();                     //M
```

### Class hierarchy

* [`Id`](src/Id.php) The base interface. Look here for a complete API reference.
    - [`PersonalId`](src/PersonalId.php) ([personnummer](http://sv.wikipedia.org/wiki/Personnummer_i_Sverige))
      The identification number of a swedish individual.
        + [`CoordinationId`](src/CoordinationId.php) ([samordningsnummer](http://sv.wikipedia.org/wiki/Samordningsnummer#Sverige))
          Identifies a non-swedish citizen registered in Sweden for tax reasons (or similar).
        + [`FakeId`](src/FakeId.php) can be used as a replacement when a person
          must have an id, but is not registered with the swedish authorities
    - [`CorporateId`](src/CorporateId.php) ([organisationsnummer](http://sv.wikipedia.org/wiki/Organisationsnummer))
      Identifies a swedish company or organization.
    - [`NullId`](src/NullId.php) Null object implementation


### Creating ID objects

Creating ID objects can be comlicated.

* A personal id can be a coordination id, if the personal identified as not a
  swedish citizen.
* A corporation id can be a personal id if the corporation is registered with a
  single individual (egenföretagare).
* A single individual company can use a coordination id if the individual is
  not a swedish citizen.
* At times you may wish to process persons without a valid swedish personal id,
  using the FakeId implementation.

To solve these difficulties a decoratable `IdFactory` is included. Create a factory
with the abilities you need by chaining factory objects at creation time.

```php
use ledgr\id\PersonalIdFactory;
use ledgr\id\CoordinationIdFactory;
$factory = new PersonalIdFactory(new CoordinationIdFactory());
$id = $factory->create('some id...');
```

In this example the factory will first try to create a `PersonalId`, if this fails
it will try to create a `CoordinationId`, if this fails it will throw an Exception.
