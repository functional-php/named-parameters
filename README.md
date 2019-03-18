# Named Parameters 

[![Build Status](https://travis-ci.org/functional-php/named-parameters.svg)](https://travis-ci.org/functional-php/named-parameters)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/functional-php/named-parameters/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/functional-php/named-parameters/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/functional-php/named-parameters/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/functional-php/named-parameters/?branch=master)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/functional-php/named-parameters.svg)](http://isitmaintained.com/project/functional-php/named-parameters "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/functional-php/named-parameters.svg)](http://isitmaintained.com/project/functional-php/named-parameters "Percentage of issues still open")
[![Chat on Gitter](https://img.shields.io/gitter/room/gitterHQ/gitter.svg)](https://gitter.im/functional-php)

It is often useful to be able to call a function or methods using named parameters. 
For example to only pass a different value for the nth default parameter.

PHP does not allow to do that, this library ought to change that.

## Installation

    composer require functional-php/named-parameters

## Basic Usage

Say you have the following function:

```
function return_array($a, $b, $c) {
    return [$a, $b, $c];
}
```

Any of the following call is equivalent:

```
use function FunctionalPHP\NamedParameters\call_user_func_array_np;

// traditional call with positional arguments
call_user_func_array_np('return_array', [1, 2, 3]);

// named arguments in the correct order
call_user_func_array_np('return_array', ['a' => 1, 'b' => 2, 'c' => 3]);

// named arguments in random order
call_user_func_array_np('return_array', ['c' => 3, 'a' => 1, 'b' => 2]);
call_user_func_array_np('return_array', ['c' => 3, 'b' => 2, 'a' => 1]);
```

## Testing

You can run the test suite for the library using:

    composer test
    
A test report will be available in the `reports` directory.

## Contributing

Any contribution welcome :

* Ideas
* Pull requests
* Issues

## Inspiration

* https://github.com/phmLabs/NamedParameters/blob/master/NamedParameters.php
* https://github.com/eclipxe13/construct-named-parameters
* https://github.com/IcecaveStudios/evoke
* https://github.com/Raphhh/trex-reflection/