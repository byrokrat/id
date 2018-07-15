# Id

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/id.svg?style=flat-square)](https://packagist.org/packages/byrokrat/id)
[![Build Status](https://img.shields.io/travis/byrokrat/id/master.svg?style=flat-square)](https://travis-ci.org/byrokrat/id)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/id.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/id)

Data types for swedish social security and corporation id numbers.

## Installation

```shell
composer require byrokrat/id:^2.0
```

Id has no userland dependencies.

## Usage

<!-- @expectOutput "820323-277519820323-27751982-03-23M1Kronobergs län" -->
```php
use byrokrat\id\PersonalId;

$id = new PersonalId('820323-2775');

// outputs 820323-2775
echo $id;

// outputs 19820323-2775
echo $id->format('Ymd-sk');

// outputs 1982-03-23
echo $id->format('Y\-m\-d');

// outputs M
echo $id->getSex();

// outputs 1 (true)
echo $id->isMale();

// outputs Kronobergs län
echo $id->getBirthCounty();
```

<!-- @expectOutput "00835000089211" -->
```php
use byrokrat\id\OrganizationId;

$id = new OrganizationId('835000-0892');

// outputs 008350000892
echo $id->format('00Ssk');

// outputs 1 (true)
echo $id->isSexUndefined();

// outputs 1 (true)
echo $id->isNonProfit();
```

### Class hierarchy

* [`IdInterface`](src/IdInterface.php) The base interface. Look here for a complete API reference.
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

Creating ID objects can be complicated.

* A personal id can be a coordination id, if the individual identified is not a
  swedish citizen.
* A corporation id can be a personal id if the corporation is registered with a
  single individual (egenföretagare).
* A single individual company can use a coordination id if the individual is
  not a swedish citizen.
* At times you may wish to process persons without a valid swedish personal id,
  using the `FakeId` implementation.

To solve these difficulties a decoratable set of factories is included. Create a
factory with the abilities you need by chaining factory objects at creation time.

<!-- @expectError -->
```php
use byrokrat\id\PersonalIdFactory;
use byrokrat\id\CoordinationIdFactory;

$factory = new PersonalIdFactory(new CoordinationIdFactory());

$id = $factory->createId('some id...');
```

In this example the factory will first try to create a `PersonalId`, if this fails
it will try to create a `CoordinationId`, if this fails it will throw an Exception.

### Formatting

Ids can be printed in custom formats using the `format()` method, where `$formatStr`
is a mix of format tokens and non-formatting characters (for a list of formatting
tokens se below).

<!-- @ignore -->
```php
echo $id->format($formatStr);
```

If you need to format a large number of ids a formatter object can be created.

<!-- @expectOutput "82" -->
```php
use byrokrat\id\Formatter\Formatter;
use byrokrat\id\PersonalId;

$formatter = new Formatter('y');

// outputs 82
echo $formatter->format(new PersonalId('820323-2775'));
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

## Symfony Bundle

To use these validation rules in your Symfony project see the third party project
[IdentityNumberValidatorBundle](https://github.com/jongotlin/IdentityNumberValidatorBundle).

## Hacking

Install dependencies

```shell
composer install
```

Install the bob build environment

```shell
composer global require chh/bob:^1.0@alpha
```

If needed put the "global" composer bin dir in your path

```shell
export PATH=$PATH:$HOME/.composer/vendor/bin/
```

Install development tools

```shell
bob install_dev_tools
```

Run tests

```shell
bob
```
