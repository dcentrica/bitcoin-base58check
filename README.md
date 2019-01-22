# Bitcoin Base58Check

[![Build Status](https://api.travis-ci.org/dcentrica/bitcoin-base58check.svg?branch=master)](https://travis-ci.org/dcentrica/bitcoin-base58check)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dcentrica/bitcoin-base58check/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dcentrica/bitcoin-base58check/?branch=master)
[![License](https://poser.pugx.org/dcentrica/bitcoin-base58check/license.svg)](https://github.com/dcentrica/bitcoin-base58check/blob/master/LICENSE.md)


## What is this?

Jan 2019: A WORK IN PROGRESS!

This is a partial PHP fork of the Python [base58CheckEncode](https://pypi.org/project/base58/) library ([Github](https://github.com/keis/base58)). This is a PHP library for base58 encoding bitcoin payment addresses and includes a checksum validation check when encoding and decoding.

## Installation

```bash
composer require dcentrica/bitcoin-base58check
```

## Requirements

Calculations are performed faster if your PHP setup includes the [GMP extension](https://secure.php.net/manual/en/book.gmp.php).

## Usage

```php
<?php

use Dcentrica\Bitcoin\Base58Check\Base58Check;

$base58 = new Base58Check('bitcoin');
$encode = $base58->encode($string);
$addr = $base58->decode($encode);
```

## Credits

People who write Python on a daily basis :-)
