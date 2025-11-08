# 02 Person

## Table of Contents

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

Generates a random title. Optionally it's possible to specify the `$gender` parameter to limit only `'male'` titles or `'female'` titles.

```php
echo $persianFaker->title();
// 'آقای' , 'خانم'

echo $persianFaker->title(gender: 'male');
// 'آقای'

echo $persianFaker->title(gender: 'female');
// 'خانم'
```

## titleMale

Generates a random title for male. Equals to `title('male')`

```php
echo $persianFaker->titleMale();
// 'آقای'
```

## titleFemale

Generates a random title for female. Equals to `title('female')`

```php
echo $persianFaker->titleFemale();
// 'خانم'
```

## name

Generates a random full name (first name and last name). Optionally it's possible to specify the `$gender` parameter to limit only `'male'` names or `'female'` names.

```php
echo $persianFaker->name();
// 'علی محمد یاوری', 'عاطفه ایزدی'

echo $persianFaker->name(gender: 'male');
// 'علی محمد یاوری'

echo $persianFaker->name(gender: 'female');
// 'عاطفه ایزدی'
```

## firstName

Generates a random first name. Optionally it's possible to specify the `$gender` parameter to limit only `'male'` names or `'female'` names.

```php
echo $persianFaker->firstName();
// 'علی محمد', 'عاطفه'

echo $persianFaker->firstName(gender: 'male');
// 'علی محمد'

echo $persianFaker->firstName(gender: 'female');
// 'عاطفه'
```

## firstNameMale

Generates a random first name for male. Equals to `firstName('male')`

```php
echo $persianFaker->firstNameMale();
// 'علی محمد'
```

## firstNameFemale

Generates a random first name for female. Equals to `firstName('female')`

```php
echo $persianFaker->firstNameFemale();
// 'عاطفه'
```

## lastName

Generates a random last name.

```php
echo $persianFaker->lastName();
// 'یاوری', 'ایزدی'
```

## nationalCode

Generates a random Iranian national code. It accepts `$state`, which allows generating national code for citizens of a specific state (default:`null`).

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
