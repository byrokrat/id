# Change Log
All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

...

## [2.1.1] - 2020-12-07

### Fixed
- Support `php 8.0`

### Changed
- Bumped minimum php requirement to `7.3`
- Build using phpunit `9`

## [2.1.0] - 2020-01-22

### Added
- `FORMAT_10_DIGITS` and `FORMAT_12_DIGITS` shorthands
- `$atDate` parameter to `IdFactoryInterface::createId()`
- `$atDate` parameter to constructors of `PersonalId` and derivatives

### Fixed
- Parsing all official skatteverket testdata
- Failure to create an id always throws an `UnableToCreateIdException`

## [2.0.0] - 2018-07-20

### Deleted
- Removed deprecated symbols

### Changed
- Requires php `7.1`
- Renamed `IdFactory` => `FailingIdFactory`

### Added
- Added `Countines`, `LegalForms` and `Sexes` interfaces with constant identifiers
- Added the `SEX_OTHER` identifier and the `isSexOther()` method to `IdInterface`

## [1.1.0] - 2017-12-20

### Deprecated
- The `Id` interface, use `IdInterface` instead
- `IdFactory::create()`, use `createId()` instead
- `IdInterface::getDate()`, use `getBirthDate()` instead

### Added
- Added `IdFactoryInterface`
- Added `$atDate` parameter to `IdInterface::getAge()`
- Added `IdInterface::getBirthDate()`

### Changed
- No longer depends on `byrokrat/checkdigit`

## [1.0.2] - 2016-08-18

### Added
- Add a `.gitattributes` to prevent unneeded files from being included in composer installs

## [1.0.1] - 2016-05-04

### Added
- Integration testing of examples in `README.md`

## [1.0.0] - 2015-01-27
- Initial release
