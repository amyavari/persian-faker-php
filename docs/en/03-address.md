# 03 Address

## secondaryAddress

Generates a random secondary address.

```php
echo $persianFaker->secondaryAddress();
// 'واحد 18' , 'طبقه 3' , 'سوئیت 4'
```

## state

Generates a random state name (province in Iran).

```php
echo $persianFaker->state();
// 'یزد' , 'کردستان' , 'سیستان و بلوچستان'
```

## city

Generates a random city name in Iran.

```php
echo $persianFaker->city();
// 'یزد' , 'سقز' , 'زاهدان'
```

## streetName

Generates a random street name in Iran.

```php
echo $persianFaker->streetName();
// 'شهر زیبا' , 'بلوار آسمان' , 'شهرک امید'
```

## address

Generates a random address in Iran includes: street name, allay name and building number.

```php
echo $persianFaker->streetName();
//  'بلوار خلیج فارس، خیابان لاله زار، خیابان پیروزی، کوچه چشمه نور، پلاک 425'
```

## postcode

Generates a random valid postal code in Iran.

**Note:** This method has been modified to include an optional `$withSeparator` argument. Set this argument to `true` if you wish to format the postal code with a dash (-) separator.

```php
echo $persianFaker->postcode();
//  '1234567890'

echo $persianFaker->postcode(true);
//  '12345-67890'
```
