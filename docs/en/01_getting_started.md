# 01 Getting Started

`persian-faker-php` is an extension for [fakerphp/faker](https://fakerphp.org/) that generates Persian-language and Iran-specific data, such as Persian text, addresses, personal details, and more.

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

To view the complete documentation for the person methods, please refer to [02-person.md](02-person.md)

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

To view the complete documentation for the address methods, please refer to [03-address.md](03-address.md)

```php
secondaryAddress()                      // 'طبقه 2'
state()                                 // 'یزد'
city()                                  // 'یزد'
streetName()                            // 'پاسداران شمالی'
address()                               // 'خیابان کارگر، کوچه گلستان، پلاک 35

// Modified: accept optional argument
postcode($withSeparator = false|true)   // '1234567890' , '12345-67890'
```
