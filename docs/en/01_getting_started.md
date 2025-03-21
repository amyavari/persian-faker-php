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

// New method
nationalCode($state = null)               // '0087199084', '1127905589'
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

### Phone

To view the complete documentation for the phone methods, please refer to [04-phone.md](04-phone.md)

```php
// Modified: accept optional arguments
phoneNumber($separator = '', $state = null)     // '03512345678'

// New methods
statePhonePrefix()                              // '035'
cellPhone($separator = '', $provider = null)    // '09121234567'
```

### Company

To view the complete documentation for the company methods, please refer to [05-company.md](05-company.md)

```php
company()       // 'گروه نگاه'
catchphrase()   // 'یک قدم تا دنیای دیجیتال'
jobTitle()      // 'برنامه نویس PHP', 'مدیر محصول'
```

---

### Text

To view the complete documentation for the text methods, please refer to [06-text.md](06-text.md)

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

To view the complete documentation for the payment methods, please refer to [07-payment.md](07-payment.md)

```php
// New methods
bank()                                                              // 'ملت', 'مهر ایران'
cardNumber($separator = '', $bank = null)                           // '6273 8157 2593 3210', '5894639748556308'
shebaNumber($withIR = true|false, $separator = '', $bank = null)    // 'IR72-0540-0008-5961-5112-7527-92'
```

### Color

To view the complete documentation for the color methods, please refer to [08-color.md](08-color.md)

```php
safeColorName()                       // 'سیاه', 'آبی'
colorName()                           // 'سبز زمردی', 'زغالی', 'زرد'
```
