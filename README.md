# ledgr/id

[![Packagist Version](https://img.shields.io/packagist/v/ledgr/id.svg?style=flat-square)](https://packagist.org/packages/ledgr/id)
[![Build Status](https://img.shields.io/travis/ledgr/id/master.svg?style=flat-square)](https://travis-ci.org/ledgr/id)
[![Quality Score](https://img.shields.io/scrutinizer/g/ledgr/id.svg?style=flat-square)](https://scrutinizer-ci.com/g/ledgr/id)
[![Dependency Status](https://img.shields.io/gemnasium/ledgr/id.svg?style=flat-square)](https://gemnasium.com/ledgr/id)

Data types for swedish social security and corporation id numbers.

> Install using **[composer](http://getcomposer.org/)**. Exists as
> **[ledgr/id](https://packagist.org/packages/ledgr/id)**
> in the **[packagist](https://packagist.org/)** repository.


Usage
-----

```php
use ledgr\id\PersonalId;
$id = new PersonalId('820323-2775');
echo $id;                            // 820323-2775
echo $id->format('Ymd-sk');          // 19820323-2775
echo $id->format('Y\-m\-d');         // 1982-03-23
echo $id->getSex();                  // M
$id->isMale();                       // true
echo $id->getBirthCounty()           // Kronobergs län
```
```php
use ledgr\id\OrganizationId;
$id = new OrganizationId('835000-0892');
echo $id->format('00Ssk');                // 008350000892
$id->isSexUndefined()                     // true
$id->isNonProfit();                       // true
```

### Class hierarchy

* [`Id`](src/Id.php) The base interface. Look here for a complete API reference.
    - [`PersonalId`](src/PersonalId.php) The identification number of a swedish individual
      ([personnummer](http://sv.wikipedia.org/wiki/Personnummer_i_Sverige)).
        + [`CoordinationId`](src/CoordinationId.php) Identifier for non-citizens
          ([samordningsnummer](http://sv.wikipedia.org/wiki/Samordningsnummer#Sverige)).
        + [`FakeId`](src/FakeId.php) Replacement usable when a person must have an id,
          but is not registered with the swedish authorities.
    - [`OrganizationId`](src/OrganizationId.php) Identifies a swedish company or organization
      ([organisationsnummer](http://sv.wikipedia.org/wiki/Organisationsnummer)).
    - [`NullId`](src/NullId.php) Null object implementation.


### Creating ID objects

Creating ID objects can be comlicated.

* A personal id can be a coordination id, if the personal identified as not a
  swedish citizen.
* A corporation id can be a personal id if the corporation is registered with a
  single individual (egenföretagare).
* A single individual company can use a coordination id if the individual is
  not a swedish citizen.
* At times you may wish to process persons without a valid swedish personal id,
  using the `FakeId` implementation.

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


### Formatting

Ids can be printed in custom formats using the `format()` method, where `$formatStr`
is a mix of format tokens and non-formatting characters (for a list of formatting
tokens se below).

```php
echo $id->format($formatStr);
```

If you need to format a large number of ids a formatter object can be created.

```php
use ledgr\id\Formatter\Formatter;
$formatter = new Formatter($formatStr);
echo $formatter->format($id);
```

#### Formatting tokens

Characters that are not formatting tokens are returned as they are by the formatter.

| Token | Description
| :---: | :--------------------------------------------------------------
| `S`   | Part of serial number before delimiter, 6 digits
| `s`   | Part of serial number after delimiter, 3 digits
| `-`   | Date and control string delimiter (- or +)
| `k`   | Check digit
| `X`   | Sex, one character (F, M or O)
| `A`   | Current age
| `L`   | Legal form (empty if not applicable)
| `B`   | Birth county (empty if not applicable)
| `\`   | Escape the following character
|       | **The following tokens only works for ids containing a date**
|       | *Year*
| `C`   | Century part of year, 2 digits
| `Y`   | A full numeric representation of a year, 4 digits
| `y`   | A two digit representation of a year
|       | *Month*
| `m`   | Numeric representation of a month, with leading zeros, 2 digits
| `n`   | Numeric representation of a month, without leading zeros, 1 through 12
| `F`   | A full textual representation of a month, such as January or March
| `M`   | A short textual representation of a month, three letters, Jan through Dec
| `t`   | Number of days in the given month 28 through 31
|       | *Week*
| `W`   | ISO-8601 week number of year, weeks starting on Monday
|       | *Day*
| `d`   | Day of the month, 2 digits with leading zeros
| `j`   | Day of the month without leading zeros, 1 to 31
| `l`   | (lowercase 'L') A full textual representation of the day of the week
| `D`   | A textual representation of a day, three letters  Mon through Sun
| `w`   | Numeric representation of the day of the week 0 (for Sunday) through 6
| `N`   | ISO-8601 numeric representation of the day of the week 1 (for Monday) through 7
| `z`   | The day of the year (starting from 0), 0 through 365
