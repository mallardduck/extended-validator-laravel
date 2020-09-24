# Extended Validation for Laravel
[![Maintainability](https://api.codeclimate.com/v1/badges/1b7e269bba89fe57e703/maintainability)](https://codeclimate.com/github/mallardduck/extended-validator-laravel/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/1b7e269bba89fe57e703/test_coverage)](https://codeclimate.com/github/mallardduck/extended-validator-laravel/test_coverage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mallardduck/extended-validator-laravel/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/mallardduck/extended-validator-laravel/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/mallardduck/extended-validator-laravel/badges/build.png?b=main)](https://scrutinizer-ci.com/g/mallardduck/extended-validator-laravel/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mallardduck/extended-validator-laravel/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)
[![codecov](https://codecov.io/gh/mallardduck/extended-validator-laravel/branch/main/graph/badge.svg)](https://codecov.io/gh/mallardduck/extended-validator-laravel)
[![Coverage Status](https://coveralls.io/repos/github/mallardduck/extended-validator-laravel/badge.svg?branch=main)](https://coveralls.io/github/mallardduck/extended-validator-laravel?branch=main)


An extension to Laravel's Validator class that provides some additional validation rules.

## Installatoin
You can install the package via composer:

```
composer require mallardduck/extended-validator-laravel
```
Just require the project and Laravel's Service Provider Auto-discovery will do the rest.  
All the new rules will be automatically registered for use without any configuration.

## Requirements
* PHP 7.3.x
* Laravel 8.x

## Available Rules
* [`PublicIp`](#publicip)
* [`PublicIpv4`](#publicipv4)
* [`PublicIpv6`](#publicipv6)
* [`UnfilledIf`](#unfilledif)
* [`UnfilledWith`](#unfilledwith)
* [`UnfilledWIthAll`](#unfilledwithall)

### `PublicIp`
Determine if the field under validation is a valid public IP address.  
Just like Laravel's `ip` rule, but IPs cannot be within private or reserved ranges.

```
$rules = [
    'ip' => 'required|public_ip',
];
```

### `PublicIpv4`
Determine if the field under validation is a valid public IPv4 address.  
Just like Laravel's `ipv4` rule, but IPs cannot be within private or reserved ranges.

```
$rules = [
    'ip' => 'required|public_ipv4',
];
```

### `PublicIpv6`
Determine if the field under validation is a valid public IPv6 address.  
Just like Laravel's `ipv6` rule, but IPs cannot be within private or reserved ranges.

```
$rules = [
    'ip' => 'required|public_ipv4',
];
```

### `UnfilledIf`
The field under validation must not be present if the anotherfield field is equal to any given value.  
Think of it as the opposite of Larave's `required_if`.

```
$rules = [
    'shape'  => 'required',
    'size'   => 'unfilled_if:shape,rect',
    'height' => 'unfilled_if:shape,square',
    'width'  => 'unfilled_if:shape,square',
];
```

### `UnfilledWith`
The field under validation must not be present only if any of the other specified fields are present.  
Think of it as the opposite of Larave's `required_with`.

```
$rules = [
    'name' => 'sometimes',
    'first_name' => 'unfilled_with:name',
    'last_name' => 'unfilled_with:name'
];
```

### `UnfilledWIthAll`
The field under validation must not be present only if all the other specified fields are present.  
Think of it as the opposite of Larave's `required_with_all`.

```
$rules = [
    'name' => 'unfilled_with_all:first_name,middle_name,last_name',
    'first_name' => 'sometimes',
    'middle_name' => 'sometimes',
    'last_name' => 'sometimes'
];
```

## Testing
```
composer test
composer check-style
```
Note: The tests are great examples of potential uses for these rules.

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.