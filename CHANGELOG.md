# Change Log
All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

- Requires php `7.1`.

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
