# 02 مشخصات یک فرد

## فهرست مطالب

-   [title](#title)
-   [titleMale](#titlemale)
-   [titleFemale](#titlefemale)
-   [name](#name)
-   [firstName](#firstname)
-   [firstNameMale](#firstnamemale)
-   [firstNameFemale](#firstnamefemale)
-   [lastName](#lastname)
-   [nationalCode](#nationalcode)

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

## nationalCode

یک کد ملی رندم ایحاد می کند. شما می توانید مقدار `$state` که نام استان است را وارد کنید تا کد ملی برای شهروند آن استان تولید شود. مقدار پیش فرض `null` است.

```php
echo $persianFaker->nationalCode();
// '0087199084', '1127905589'

echo $persianFaker->nationalCode(state: 'yazd');
// '4424489752', '4434728431'

// State name guide for Iran:
'azar_sharghi'          // Azarbayegane Sharghi آذربایجان شرقی
'azar_gharbi'           // Azarbayegane Gharbi آذربایجان غربی
'ardabil'               // Ardabil اردبیل
'esfahan'               // Esfahan اصفهان
'ilam'                  // Ilam ایلام
'bushehr'               // Bushehr بوشهر
'tehran'                // Tehran تهران
'chahar_mahal'          // Chahar Mahal va Bakhtiari چهارمحال و بختیاری
'khorasan_razavi'       // Khorasan Razavi خراسان رضوی
'khorasan_jonoobi'      // Khorasan Jonoobi خراسان جنوبی
'khorasan_shemali'      // Khorasan Shemali خراسان شمالی
'khoozestan'            // Khoozestan خوزستان
'zanjan'                // Zanjan زنجان
'semnan'                // Semnan سمنان
'sistan'                // Sistan va Baloochestan سیستان و بلوچستان
'alborz'                // Alborz البرز
'qom'                   // Qom قم
'qazvin'                // Qazvin قزوین
'kordestan'             // Kordestan کردستان
'kerman'                // Kerman کرمان
'kermanshah'            // Kermanshah کرمانشاه
'koh_and_boyer'         // Kohgiluyeh va Boyer Ahmad کهگیلویه و بویراحمد
'golestan'              // Golestan گلستان
'gilan'                 // Gilan گیلان
'lorestan'              // Lorestan لرستان
'mazandaran'            // Mazandaran مازندران
'markazi'               // Markazi مرکزی
'hormozgan'             // Hormozgan هرمزگان
'hamadan'               // Hamadan همدان
'yazd'                  // Yazd یزد
```
