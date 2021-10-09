# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [3.0.3] - 2021-10-09
## [3.0.2] - 2021-04-24
### Changed
- Removed support for php 7.4 bumped minimum to 8.0
- Adjust the gitattributes file
- fix CI tests

## [2.3.1] - 2021-04-24
## [2.3.0] - 2021-04-24
### Changed
- General refactors to improve code quality and such.
- Remove need to set name in constructor parameters.

## [2.2.0] - 2021-04-21
### Added
- A new `NonPublicIpv4` rule

## [2.1.1] - 2021-04-13
### Changed
- Made all classes final.
- Remove some unused code.
- Switch to GitHub actions from TravisCI.

## [2.1.0] - 2021-04-12
### Changed
- Required laravel version to `8.33` which provides a native `ProhibitedIf`.

### Removed
- Pulled out the `ProhibitedIf` rule as it collides with the native `prohibited_if`. Not breaking change due to new laravel requirement.

## [2.0.1] - 2021-04-12
### Added
- Support for PHP 8.0.x

## [2.0.0] - 2021-03-08
### Added
- A changelog file that will use keepachangelog.

### Changed
- All the `Unfilled*` rules to use `Prohibited*` instead.

# Undocumented Releases
## [1.2.2]
## [1.2.1]
## [1.2.0]
## [1.1.0]
## [1.0.0]

[Unreleased]: https://github.com/mallardduck/extended-validator-laravel/compare/3.0.3...main
[3.0.2]: https://github.com/mallardduck/extended-validator-laravel/compare/3.0.2...3.0.3
[3.0.2]: https://github.com/mallardduck/extended-validator-laravel/compare/3.0.0...3.0.2
[3.0.0]: https://github.com/mallardduck/extended-validator-laravel/compare/2.3.1...3.0.0
[2.3.1]: https://github.com/mallardduck/extended-validator-laravel/compare/2.3.0...2.3.1
[2.3.0]: https://github.com/mallardduck/extended-validator-laravel/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/mallardduck/extended-validator-laravel/compare/2.1.1...2.2.0
[2.1.1]: https://github.com/mallardduck/extended-validator-laravel/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/mallardduck/extended-validator-laravel/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/mallardduck/extended-validator-laravel/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/mallardduck/extended-validator-laravel/compare/1.2.2...2.0.0
[1.2.2]: https://github.com/mallardduck/extended-validator-laravel/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/mallardduck/extended-validator-laravel/compare/1.2.0...1.2.1
[1.2.0]: https://github.com/mallardduck/extended-validator-laravel/compare/1.1.0...1.2.0
[1.1.0]: https://github.com/mallardduck/extended-validator-laravel/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/mallardduck/extended-validator-laravel/releases/tag/1.0.0
