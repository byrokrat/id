# ledgr/id

[![Latest Stable Version](https://poser.pugx.org/ledgr/id/v/stable.png)](https://packagist.org/packages/ledgr/id)
[![Build Status](https://travis-ci.org/ledgr/id.png?branch=master)](https://travis-ci.org/ledgr/id)
[![Code Coverage](https://scrutinizer-ci.com/g/ledgr/id/badges/coverage.png?s=7a9fefd7d6535b32d2d97be1a9e583535391dd33)](https://scrutinizer-ci.com/g/ledgr/id/)
[![Dependency Status](https://gemnasium.com/ledgr/id.png)](https://gemnasium.com/ledgr/id)

Data types for swedish social security and corporation id numbers

> Install using [composer](http://getcomposer.org/). Exists as **ledgr/id** in
> the packagist repository.


Usage
-----
`PersonalId` is the identification number of a swedish individual.

```php
use ledgr\id\PersonalId;
$id = new PersonalId('820323-2775');
echo $id->getId();                      //820323-2775
echo $id->getLongId();                  //19820323-2775
echo $id->getDate()->format('Y-m-d');   //1982-03-23
echo $id->getSex();                     //M
```

`CoordinationId` identifies a non-swedish citizen registered in Sweden for tax
reasons (or similar).

`FakeId` can be used as a replacement when a person must have an id, but is not
registered with the swedish authorities.

`CorporateId` identifies a swedish company or organization.


### Creating ID objects

Creating ID objects can be comlicated.

* A personal id can be a coordination id, if the personal identified as not a
swedish citicen.
* A corporation id can be a personal id if the corporation is registered with a
single individual (egenföretagare).
* A single individual company can use a coordination id if the individual is
not a swedish citizen.
* At times you may wish to process persons without a valid swedish personal id,
using the FakeId implementation.

To solve these difficulties a decoratable IdFactory is included. Create a factory
with the abilities you need by chaining factory objects at creation time.

```php
use ledgr\id\PersonalIdFactory;
use ledgr\id\CoordinationIdFactory;
$factory = new PersonalIdFactory(new CoordinationIdFactory());
$id = $factory->create('some id...');
```

In this example the factory will first try to create a PersonalId, if this fails
it will try to create a CoordinationId, if this fails it will throw an Exception.
