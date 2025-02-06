# Persian Faker for PHP

<img src="https://banners.beyondco.de/Persian%20Faker%20PHP.png?theme=dark&packageManager=composer+require&packageName=--dev+amyavari%2Fpersian-faker-php&pattern=architect&style=style_1&description=Make+fake+Persian+and+Iran-specific+data+with+ease&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Fwww.php.net%2Fimages%2Flogos%2Fnew-php-logo.svg">

![PHP Version](https://img.shields.io/packagist/php-v/amyavari/persian-faker-php)
![Packagist Version](https://img.shields.io/packagist/v/amyavari/persian-faker-php?label=version)
![Packagist Downloads](https://img.shields.io/packagist/dt/amyavari/persian-faker-php)
![Packagist License](https://img.shields.io/packagist/l/amyavari/persian-faker-php)
![Tests](https://img.shields.io/github/actions/workflow/status/amyavari/persian-faker-php/tests.yml?label=tests)
---

`persian-faker-php` is an extension for [fakerphp/faker](https://fakerphp.org/) that generates Persian-language and Iran-specific data, such as Persian text, addresses, personal details, and more.
To view the Persian documentation, please refer to [README_FA.md](/docs/README_FA.md).

این کتابخانه بر پایه [fakerphp/faker](https://fakerphp.org/) نوشته شده است و هدف آن پشتیبانی از متن و مشخصات فارسی و بهینه‌شده برای اطلاعات کشور ایران می‌باشد. <br> برای مشاهده راهنمای فارسی لطفاً فایل [README_FA.md](/docs/README_FA.md) را مشاهده کنید. 

## Requirements

-   PHP version `8.2.0` or higher

## Installation

To install the package, use Composer.

```bash
composer require --dev amyavari/persian-faker-php
```

**Note:** This package is intended for use in a development environment, so it's recommended to install it with the `--dev` flag.

## Usage

You can easily create an instance of Faker in your PHP projects by calling the `create()` method from the `Factory` class

```php
    $persianFaker = \AliYavari\PersianFaker\Factory::create();
```

## Available Methods

Most methods in `persian-faker-php` are extensions of the [fakerphp/faker](https://fakerphp.org/) library, supporting only Persian language and Iran-specific data. The implementation and arguments for these methods are the same as those in the original Faker library.

### Person Details

```php
    title($gender = null|'male'|'female')     // 'آقای'
    titleMale()                               // 'آقای'
    titleFemale()                             // 'خانم'
    name($gender = null|'male'|'female')      // 'علی محمد یاوری'
    firstName($gender = null|'male'|'female') // 'علی محمد'
    firstNameMale()                           // 'علی محمد'
    firstNameFemale()                         // 'نیوشا'
    lastName()                                // 'یاوری'
```

### Address
