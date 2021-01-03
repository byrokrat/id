![byrokrat](res/logo.svg)

# Personal Identity

[![Packagist Version](https://img.shields.io/packagist/v/byrokrat/id.svg?style=flat-square)](https://packagist.org/packages/byrokrat/id)
[![Build Status](https://img.shields.io/travis/byrokrat/id/master.svg?style=flat-square)](https://travis-ci.com/github/byrokrat/id)
[![Quality Score](https://img.shields.io/scrutinizer/g/byrokrat/id.svg?style=flat-square)](https://scrutinizer-ci.com/g/byrokrat/id)

Data types for swedish personal identity and corporation id numbers.

## Installation

```shell
composer require byrokrat/id
```

## Usage

<!--
    @example PersonalId
    @expectOutput "/^940323[+-]2383940323[+-]2383199403232383940323\d{2,3}1$/"
-->
```php
use byrokrat\id\PersonalId;
use byrokrat\id\IdInterface;

$id = new PersonalId('940323-2383');

// outputs 940323-2383
echo $id;

// outputs 940323-2383
echo $id->format(IdInterface::FORMAT_10_DIGITS);

// outputs 199403232383
echo $id->format(IdInterface::FORMAT_12_DIGITS);

// outputs 940323
echo $id->format('ymd');

// outputs something like 25
echo $id->getAge();

// outputs 1 (true)
echo $id->isFemale();
```

<!--
    @example OrganizationId
    @expectOutput "835000-089200835000089211"
-->
```php
use byrokrat\id\OrganizationId;
use byrokrat\id\IdInterface;

$id = new OrganizationId('835000-0892');

// outputs 835000-0892
echo $id->format(IdInterface::FORMAT_10_DIGITS);

// outputs 008350000892
echo $id->format(IdInterface::FORMAT_12_DIGITS);

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

<!--
    @example IdFactory
-->
```php
use byrokrat\id\PersonalIdFactory;
use byrokrat\id\CoordinationIdFactory;

$factory = new PersonalIdFactory(new CoordinationIdFactory);

$id = $factory->createId('940323-2383');
```

In this example the factory will first try to create a `PersonalId`, if this fails
it will try to create a `CoordinationId`, if this fails it will throw an Exception.

The following factories are included:

* [`PersonalIdFactory`](src/PersonalIdFactory.php)
* [`CoordinationIdFactory`](src/CoordinationIdFactory.php)
* [`FakeIdFactory`](src/FakeIdFactory.php)
* [`OrganizationIdFactory`](src/OrganizationIdFactory.php)
* [`NullIdFactory`](src/NullIdFactory.php)
* [`FailingIdFactory`](src/FailingIdFactory.php)

### Controlling the delimiter and century of ids containing dates

In order to controll the computation of dates you may specify at what time
parsing takes place by passing a datetime object.

<!-- @example ParseDate -->
<!-- @expectOutput "20101910" -->
```php
use byrokrat\id\PersonalIdFactory;

$factory = new PersonalIdFactory;

// Year interpreted as 2010 as parsing is done 2020
$young = $factory->createId('1001012382', new \DateTime('20200101'));

// Year interpreted as 1910 as parsing is done 1990
$older = $factory->createId('1001012382', new \DateTime('19900101'));

// outputs 2010
echo $young->format('Y');

// outputs 1910
echo $older->format('Y');
```

Specifying parse date also affects what delimiter is used.

<!-- @example Controlling-The-Delimiter -->
<!-- @expectOutput "400107+9120" -->
```php
use byrokrat\id\PersonalIdFactory;

$factory = new PersonalIdFactory;

// Delimiter is '+' as parsing is done in 2050
$id = $factory->createId('194001079120', new \DateTime('20500101'));

// outputs 400107+9120
echo $id;
```

### Formatting

Ids can be printed in custom formats using the `format()` method, where `$formatStr`
is a mix of format tokens and non-formatting characters (for a list of formatting
tokens se below).

<!-- @ignore -->
```php
echo $id->format($formatStr);
```

If you need to format a large number of ids a formatter object can be created.

<!--
    @example Formatter
    @expectOutput "94"
-->
```php
use byrokrat\id\Formatter\Formatter;
use byrokrat\id\PersonalId;

$formatter = new Formatter('y');

// outputs 82
echo $formatter->format(new PersonalId('940323-2383'));
```

#### Formatting tokens

Characters that are not formatting tokens are returned as they are by the formatter.

| Token | Description
| :---: | :--------------------------------------------------------------
| `C`   | Century, 2 digits (00 if not applicable)
| `S`   | Part of serial number before delimiter, 6 digits
| `-`   | Date and control string delimiter (- or +)
| `s`   | Part of serial number after delimiter, 3 digits
| `k`   | Check digit
| `X`   | Sex, F, M or O (empty if not applicable)
| `L`   | Legal form (empty if not applicable)
| `B`   | Birth county (empty if not applicable)
| `\`   | Escape the following character
|       | **The following tokens are only valid for ids containing a date**
| `A`   | Current age
|       | *Year*
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

## Definitions

Swedish sources on the construction and usage of id numbers:

* [Folkbokföringslagen](https://www.riksdagen.se/sv/dokument-lagar/dokument/svensk-forfattningssamling/folkbokforingslag-1991481_sfs-1991-481#P18)
* [Statistiska centralbyrån on personal identity numbers](https://www.scb.se/contentassets/8d9d985ca9c84c6e8d879cc89a8ae479/ov9999_2016a01_br_be96br1601.pdf)

## Symfony Bundle

To use as validation rules in your Symfony project see the third party package
[IdentityNumberValidatorBundle](https://github.com/jongotlin/IdentityNumberValidatorBundle).
