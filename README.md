Swedish Technical Bureaucracy (STB)
===================================
[![Build Status](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy.png?branch=master)](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/badges/quality-score.png?s=7b3a25b6ccb38244fb5bb0b5d3fa2556bf35726e)](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/)
[![Code Coverage](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/badges/coverage.png?s=53a09ec7902fb2e92b1264a9a527162f21639187)](https://scrutinizer-ci.com/g/iio/Swedish-Technical-Bureaucracy/)

STB is a collection of classes useful when processing data related to swedish 
bureaucracy and banking systems. The functionality is split into different
subpackages.


Table of contents
-----------------
* [Installing](#installation-using-composer)
* [Accounting](#accounting)
* [Banking](#banking)
    * [Creating bank account objects](#creating-bank-account-objects)
* [Billing](#billing)
* [ID](#id)
* [Utils](#utils)
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
Data types for accounts in the swedish banking system. Se `AccountBuilder` for
a way to transparently create account objects.

### Creating bank account objects

    use iio\stb\Banking\AccountBuilder;
    $builder = new AccountBuilder();
    $account = $builder->setAccount('3300,1111111116')->getAccount();
    // $account is an instance of iio\stb\Banking\NordeaPerson


Billing
-------
Invoice and support classes.


ID
--
Data types for swedish social security and corporation id numbers. Se
`CorporateIdBuilder` and `PersonalIdBuilder` for ways to transparently create ID
objects.

    use iio\stb\ID\PersonalIdBuilder;
    $builder = new PersonalIdBuilder();
    $id = $builder->enableCoordinationId()
        ->setId('701063-2391')
        ->getId();
    // $id is an instance of iio\stb\ID\CoordinationId

### PersonalId

    use iio\stb\ID\PersonalId;
    $id = new PersonalId('820323-2775');
    echo $id->getId();                      //820323-2775
    echo $id->getLondId();                  //19820323-2775
    echo $id->getDate()->format('Y-m-d');   //1982-03-23
    echo $id->getSex();                     //M


Utils
-----
Some utility classes.
 
 * `Amount` represent transaction amounts using bcmath for arithmetic precision.
 
 * `OCR` represents transaction numbers used in the swedish banking system.


Continuous integration
----------------------
Running unit tests and other code analysis tools can be handled using `phing`.
To run CI tests type `phing` from the project root directory, point your browser
to `build/index.html` to view the results.


Running unit tests
------------------
From project root simply type

    > phpunit
