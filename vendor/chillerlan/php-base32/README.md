[![version][packagist-badge]][packagist]
[![license][license-badge]][license]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]
[![Scrunitizer][scrutinizer-badge]][scrutinizer]
[![SensioLabsInsight][sensio-badge]][sensio]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-base32.svg
[packagist]: https://packagist.org/packages/chillerlan/php-base32
[license-badge]: https://img.shields.io/packagist/l/chillerlan/php-base32.svg
[license]: https://github.com/codemasher/php-base32/blob/master/LICENSE
[travis-badge]: https://travis-ci.org/codemasher/php-base32.svg?branch=master
[travis]: https://travis-ci.org/codemasher/php-base32
[coverage-badge]: https://codecov.io/github/codemasher/php-base32/coverage.svg?branch=master
[coverage]: https://codecov.io/github/codemasher/php-base32
[scrutinizer-badge]: https://scrutinizer-ci.com/g/codemasher/php-base32/badges/quality-score.png?b=master
[scrutinizer]: https://scrutinizer-ci.com/g/codemasher/php-base32
[sensio-badge]: https://img.shields.io/sensiolabs/i/0baf987e-6197-4b01-b277-0e5862862a1b.svg
[sensio]: https://insight.sensiolabs.com/projects/0baf987e-6197-4b01-b277-0e5862862a1b

# php-base32

A Base32 implementation based on the one by [Shannon Wynter](https://fremnet.net/article/215/class-base32).

## Requirements
- PHP 5.6+, PHP 7

## Installation
### Using [composer](https://getcomposer.org)

*Terminal*
```sh
composer require chillerlan/php-base32:dev-master
```

*composer.json*
```json
{
	"require": {
		"php": ">=5.6.0",
		"chillerlan/php-base32": "dev-master"
	}
}
```

### Manual installation
Download the desired version of the package from [master](https://github.com/codemasher/php-base32/archive/master.zip) 
and extract the contents to your project folder. Point the namespace `chillerlan/Base32` to the folder `src` of the package.

Profit!
