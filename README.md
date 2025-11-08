# Persian Faker for PHP

<img src="https://banners.beyondco.de/Persian%20Faker%20PHP.png?theme=dark&packageManager=composer+require&packageName=--dev+amyavari%2Fpersian-faker-php&pattern=architect&style=style_1&description=Make+fake+Persian+and+Iran-specific+data+with+ease&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Fwww.php.net%2Fimages%2Flogos%2Fnew-php-logo.svg">

![PHP Version](https://img.shields.io/packagist/php-v/amyavari/persian-faker-php)
![Packagist Version](https://img.shields.io/packagist/v/amyavari/persian-faker-php?label=version)
![Packagist Downloads](https://img.shields.io/packagist/dt/amyavari/persian-faker-php)
![Packagist License](https://img.shields.io/packagist/l/amyavari/persian-faker-php)
![Tests](https://img.shields.io/github/actions/workflow/status/amyavari/persian-faker-php/tests.yml?label=tests)

---

`persian-faker-php` is an extension for [fakerphp/faker](https://fakerphp.org/) that generates Persian-language and Iran-specific data, such as Persian text, addresses, personal details, and more.  
To view the Persian documentation, please refer to [docs/fa/01_getting_started.md](/docs/fa/01_getting_started.md).

این کتابخانه بر پایه کتابخانه [fakerphp/faker](https://fakerphp.org/) ساخته شده و هدف آن پشتیبانی از متن و مشخصات فارسی به‌طور خاص برای اطلاعات کشور ایران است.  
برای مشاهده راهنمای فارسی، لطفاً به فایل [docs/fa/01_getting_started.md](/docs/fa/01_getting_started.md) مراجعه کنید.

## Requirements

-   PHP version `8.2.0` or higher

## Table of Contents

-   [Installation](#instantiation)
-   [Usage](#usage)
-   [Available Methods](#available-methods)
    -   [Person Details](#person-details)
    -   [Address](#address)
    -   [Phone](#phone)
    -   [Company](#company)
    -   [Text](#text)
    -   [Payment](#payment)
    -   [Color](#color)
-   [Contributing](#contributing)

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

### Usage Helper

If you prefer a simpler way to get a Persian Faker instance, you can use the global `persian_faker()` helper function provided by this package. This is especially useful in Laravel or any PHP project where global helpers are available.

```php
$persianFaker = persian_faker();
```

This helper will automatically resolve the Faker instance, using the Laravel service container if available, or falling back to a direct instantiation otherwise.

## Available Methods

Most methods in `persian-faker-php` are extensions of the [fakerphp/faker](https://fakerphp.org/) library, supporting only Persian language and Iran-specific data. The implementation and arguments for these methods are the same as those in the original Faker library.

### Person Details

To view the complete documentation for the person methods, please refer to [docs/en/02-person.md](./docs/en/02-person.md)

```php
title($gender = null|'male'|'female')     // 'آقای'
titleMale()                               // 'آقای'
titleFemale()                             // 'خانم'
name($gender = null|'male'|'female')      // 'علی محمد یاوری'
firstName($gender = null|'male'|'female') // 'علی محمد'
firstNameMale()                           // 'علی محمد'
firstNameFemale()                         // 'نیوشا'
lastName()                                // 'یاوری'

// New method
nationalCode($state = null)               // '0087199084', '1127905589'
```

### Address

To view the complete documentation for the address methods, please refer to [docs/en/03-address.md](./docs/en/03-address.md)

```php
secondaryAddress()                      // 'طبقه 2'
state()                                 // 'یزد'
city()                                  // 'یزد'
streetName()                            // 'پاسداران شمالی'
address()                               // 'خیابان کارگر، کوچه گلستان، پلاک 35

// Modified: accept optional argument
postcode($withSeparator = false|true)   // '1234567890' , '12345-67890'
```

### Phone

To view the complete documentation for the phone methods, please refer to [docs/en/04-phone.md](./docs/en/04-phone.md)

```php
// Modified: accept optional arguments
phoneNumber($separator = '', $state = null)     // '03512345678', '035-12345678'

// New methods
statePhonePrefix()                              // '035'
cellPhone($separator = '', $provider = null)    // '09121234567', '0912-123-4567'
```

### Company

To view the complete documentation for the company methods, please refer to [docs/en/05-company.md](./docs/en/05-company.md)

```php
company()       // 'گروه نگاه'
catchphrase()   // 'یک قدم تا دنیای دیجیتال'
jobTitle()      // 'برنامه نویس PHP', 'مدیر محصول'
```

---

### Text

To view the complete documentation for the text methods, please refer to [docs/en/06-text.md](./docs/en/06-text.md)

```php
word()                                                          // 'آتش', 'خاکستری'
words($nb = 3, $asText = false|true)                            // ['خاکستری', 'سریع' , 'دارچین'], 'خاکستری سریع دارچین'

sentence($nbWords = 6, $variableNbWords = true|false)           // '.نویس اتوبوس برنامه دار.', 'دیجیتال دنیا و بی یخ'
sentences($nb = 3, $asText = false|true)                        // ['خاکستری سریع دارچین','.یخ در بهشت.'], 'خاکستری سریع دارچین. یخ در بهشت.'

paragraph($nbSentences = 3, $variableNbSentences = true|false)  // 'خاکستری سریع دارچین اما اینجا. یخ در بهشت بها. دیجیتال دنیا و بی یخ..'
paragraphs($nb = 3, $asText = false|true)

text($maxNbChars = 200)
// 'ثانیه رنگ هفته ماه ملی پاییز انسان تنظیم تخم‌مرغ بخار نهاد صعود بیعت تند تفکر توانا پناهگاه برنامه سکه برگ'
```

### Payment

To view the complete documentation for the payment methods, please refer to [docs/en/07-payment.md](./docs/en/07-payment.md)

```php
// New methods
bank()                                                              // 'ملت', 'مهر ایران'
cardNumber($separator = '', $bank = null)                           // '6273 8157 2593 3210', '5894639748556308'
shebaNumber($withIR = true|false, $separator = '', $bank = null)    // 'IR72-0540-0008-5961-5112-7527-92'
```

### Color

To view the complete documentation for the color methods, please refer to [docs/en/08-color.md](./docs/en/08-color.md)

```php
safeColorName()                       // 'سیاه', 'آبی'
colorName()                           // 'سبز زمردی', 'زغالی', 'زرد'
```

## Contributing

Thank you for considering contributing to the Persian Faker PHP! The contribution guide can be found in the [CONTRIBUTING.md](CONTRIBUTING.md)

## License

**Persian Faker PHP** was created by **[Ali Mohammad Yavari](https://www.linkedin.com/in/ali-m-yavari/)** under the **[MIT license](https://opensource.org/licenses/MIT)**.

---

This package utilizes the [nunomaduro/skeleton-php](https://github.com/nunomaduro/skeleton-php) repository as a starting point and for configuration settings.
