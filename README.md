Swedish Technical Bureaucracy (STB)
===================================

[![Build Status](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy.png?branch=master)](https://travis-ci.org/iio/Swedish-Technical-Bureaucracy)

STB is a collection of classes useful when processing data related to swedish 
bureaucracy and banking systems. Browse the source for a complete listing.


Accounting
----------

The accounting subpackage handles bookkeeping data. Specifically transaction
data can be read and written in the SIE format. Accounting templates from the
VISMA series of accounting software is also supported.


Banking
-------

Data types for accounts in the swedish banking system. Se `AccountBuilder` for
a way to transparently create account objects.

    use iio\stb\Banking\AccountBuilder;
    $builder = new AccountBuilder();
    $account = $builder->setAccount('3300,1111111116')->getAccount();
    // $account is an instance of iio\stb\Banking\NordeaPerson


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
