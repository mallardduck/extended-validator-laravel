# Extended Validation for Laravel
[![Maintainability](https://api.codeclimate.com/v1/badges/1b7e269bba89fe57e703/maintainability)](https://codeclimate.com/github/mallardduck/extended-validator-laravel/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/1b7e269bba89fe57e703/test_coverage)](https://codeclimate.com/github/mallardduck/extended-validator-laravel/test_coverage)
[![codecov](https://codecov.io/gh/mallardduck/extended-validator-laravel/branch/main/graph/badge.svg)](https://codecov.io/gh/mallardduck/extended-validator-laravel)
[![Coverage Status](https://coveralls.io/repos/github/mallardduck/extended-validator-laravel/badge.svg?branch=main)](https://coveralls.io/github/mallardduck/extended-validator-laravel?branch=main)


An extension to Laravel's Validator class that provides some additional validation rules.

## Installation
You can install the package via composer:

```
composer require mallardduck/extended-validator-laravel
```
Just require the project and Laravel's Service Provider Auto-discovery will do the rest.  
All the new rules will be automatically registered for use without any configuration.

## Requirements
* PHP 8.x
* Laravel 8.32.x (or greater)

### Past PHP version support
| PHP | Package |
|-----|---------|
| 8.0 | Current |
| 7.4 | 2.3.1 |

## Available Rules
* [`PublicIp`](#publicip)
* [`PublicIpv4`](#publicipv4)
* [`NonPublicIpv4`](#nonpublicipv4)
* [`NotInIf`](#notinif)
* [`NotInIfValue`](#notinifvalue)
* [`PublicIpv6`](#publicipv6)
* [`ProhibitedIf`](#prohibitedif)
* [`ProhibitedWith`](#prohibitedwith)
* [`ProhibitedWithAll`](#prohibitedwithall)

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

### `NonPublicIpv4`
Determine if the field under validation is a valid non-public IPv4 address.  
Just like Laravel's `ipv4` rule, but IPs should only be within private or reserved ranges.

```
$rules = [
    'ip' => 'required|non_public_ipv4',
];
```

### `NotInIf`
#### `not_in_if:anotherfield,value,...`
The field under validation must not be included in the given list of values only when the given fieled is truthy.  
Think of this as a conditional version of [`not_in`](https://laravel.com/docs/8.x/validation#rule-not-in) rule.

```
$rules = [
    'size' => ['sometimes', 'not_in_if_value:is_square,large,super', 'in:small,medium,large,super',],
    'is_square' => ['required', 'boolean'],
];
```

### `NotInIfValue`
#### `not_in_if_value:anotherfield,anotherfield_value,value,...`
The field under validation must not be included in the given list of values only when the value of the `anotherfield` field is equal to `anotherfield_value`.  
Think of this as a conditional version of [`not_in`](https://laravel.com/docs/8.x/validation#rule-not-in) rule.

```
$rules = [
    'size' => ['sometimes', 'not_in_if_value:shape,square,large,super', 'in:small,medium,large,super',],
    'shape' => ['required', 'in:square,rectangle'],
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

### `ProhibitedIf`
It's now suggested that you use the native Laravel version of this rule. 
This package now requires the version that ships this, so it should be there.  

For more info see the docs: https://laravel.com/docs/8.x/validation#rule-prohibited-if

### `Probhits` aka `ProhibitedWith`
It's now suggested that you use the native Laravel version of this rule, even though it's slightly different.
This package will require that version moving forward so the rule will be there.

For more info, see: https://laravel.com/docs/9.x/validation#rule-prohibits

### `ProhibitedWithAll`
Use of the field under validation is prohibited only if all the other specified fields are present.  
Think of it as the opposite of Laravel's `required_with_all`.

```
$rules = [
    'name' => 'prohibited_with_all:first_name,middle_name,last_name',
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
