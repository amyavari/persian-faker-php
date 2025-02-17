# 02 مشخصات یک فرد

## title

یک عنوان رندم ایجاد می کند. می توانید پارامتر `$gender` را وارد کنید تا عنوان برای یک آقا `'male'` باشد یا برای یک خانم `'female'`

```php
echo $persianFaker->title();
// 'آقای' , 'خانم'

echo $persianFaker->title(gender: 'male');
// 'آقای'

echo $persianFaker->title(gender: 'female');
// 'خانم'
```

## titleMale

یک عنوان رندم برای یک آقا ایجاد می کنید. معادل `title('male')`

```php
echo $persianFaker->titleMale();
// 'آقای'
```

## titleFemale

یک عنوان رندم برای یک خانم ایجاد می کنید. معادل `title('female')`

```php
echo $persianFaker->titleFemale();
// 'خانم'
```

## name

یک نام کامل (نام و نام خانودگی) رندم ایجاد می کند. می توانید پارامتر `$gender` را وارد کنید تا نام برای یک آقا `'male'` باشد یا برای یک خانم `'female'`

```php
echo $persianFaker->name();
// 'علی محمد یاوری', 'عاطفه ایزدی'

echo $persianFaker->name(gender: 'male');
// 'علی محمد یاوری'

echo $persianFaker->name(gender: 'female');
// 'عاطفه ایزدی'
```

## firstName

یک نام رندم ایجاد می کند. می توانید پارامتر `$gender` را وارد کنید تا نام برای یک آقا `'male'` باشد یا برای یک خانم `'female'`

```php
echo $persianFaker->firstName();
// 'علی محمد', 'عاطفه'

echo $persianFaker->firstName(gender: 'male');
// 'علی محمد'

echo $persianFaker->firstName(gender: 'female');
// 'عاطفه'
```

## firstNameMale

یک نام رندم برای یک آقا ایجاد می کنید. معادل `firstName('male')`

```php
echo $persianFaker->firstNameMale();
// 'علی محمد'
```

## firstNameFemale

یک نام رندم برای یک خانم ایجاد می کنید. معادل `firstName('female')`

```php
echo $persianFaker->firstNameFemale();
// 'عاطفه'
```

## lastName

یک نام خانوادگی رندم ایحاد می کند.

```php
echo $persianFaker->lastName();
// 'یاوری', 'ایزدی'
```
