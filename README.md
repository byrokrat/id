Swedish Technical Bureaucracy (STB)
===================================
[![Build Status](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy.png?branch=master)](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy)
[![Code Coverage](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/badges/coverage.png?s=53a09ec7902fb2e92b1264a9a527162f21639187)](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/badges/quality-score.png?s=7b3a25b6ccb38244fb5bb0b5d3fa2556bf35726e)](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/)

STB is a collection of classes useful when processing data related to swedish 
bureaucracy and banking systems. The functionality is split into different
subpackages.


Table of contents
-----------------
* [Installing](#installation-using-composer)
* [Accounting](#accounting)
* [Banking](#banking)
    * [Creating bank account objects](#creating-bank-account-objects)
* [ID](#id)
    * [PersonalId](#personalid)
    * [Creating ID objects](#creating-id-objects)
* [Continuous integration](#continuous-integration)
* [Unit testing](#running-unit-tests)


Installation using composer
---------------------------
The usage of [composer](http://getcomposer.org/) is recommended. Simply add
`iio/stb` to your list of required libraries.


Accounting
----------
The accounting subpackage handles bookkeeping data. Specifically transaction
data can be read and written in the SIE format. Accounting templates from the
VISMA series of accounting software is also supported.


Banking
-------
Data types for accounts in the swedish banking system. Se `BankAccountFactory` for
a way to transparently create account objects.

### Creating bank account objects

    use iio\stb\Banking\BankAccountFactory;
    $account = BankAccountFactory::create('3300,1111111116');
    // $account is an instance of iio\stb\Banking\NordeaPerson


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
