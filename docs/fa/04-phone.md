# 04 شمراه تلفن

## فهرست مطالب

-   [statePhonePrefix](#statephoneprefix)
-   [phoneNumber](#phonenumber)
-   [cellPhone](#cellphone)

## statePhonePrefix

یک پیش شماره تلفن ثابت ایجاد می کند.

**توجه:** این تابع در کتابخانه [fakerphp/faker](https://fakerphp.org/) وجود ندارد.

```php
echo $persianFaker->statePhonePrefix();
// '035', '021', '013'
```

## phoneNumber

یک شماره ثابت با پیش شماره ایجاد می کند.

**توجه:** این تابع ویرایش شده است و دو آرگومان اختیاری دریافت می کند. `$separator` که مقدار پیش فرض آن `''` است و جدا کننده بین پیش شماره شهر و شماره تلفن می باشد و `$state` که نام استان است که می خواهید شماره با آن پیش شماره تولید شود. مقدار پیش فرض `null` می باشد.

```php
echo $persianFaker->phoneNumber();
// '03512345678', '02112345678'

echo $persianFaker->phoneNumber(state: 'yazd');
// '03512345678', '03587654321'

echo $persianFaker->phoneNumber(separator: '-');
// '035-12345678', '021-12345678'

echo $persianFaker->phoneNumber(separator: ' ', state: 'gilan');
// '013 12345678', '013 87654321'


// راهنمای نام استان های ایران برای آرگومان $state:
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

## cellPhone

یک شماره همراه (موبایل) رندم ایجاد می کند.

**توجه:** این تابع در کتابخانه [fakerphp/faker](https://fakerphp.org/) وجود ندارد.  
این تابع پارامتر اختیاری `$separator` با مقدار پیش فرض `''` دریافت می کند که جدا کننده بین پیش شماره اپراتور، سه رقم اول و چهار رقم آخر شماره می باشد. همچنین با تعیین مقدار `$provider` می توانید تعیین کنید که شماره همراه با پیش شماره کدام اپراتور ایجاد شود. مقدار پیش فرض آن `null` است.

```php
echo $persianFaker->cellPhone();
// '09121234567', '09301234567'

echo $persianFaker->cellPhone(provider: 'mtn');
// '09301234567', '09391234567'

echo $persianFaker->cellPhone(separator: '-');
// '0912-123-4567', '0930-123-4567'

echo $persianFaker->cellPhone(separator: ' ', provider: 'mci');
// '0912 123 4567', '0990 123 4567'


// راهنمای نام اپراتورها برای آرگومان $provider:
'mci'       // IR-MCI همراه اول
'mtn'       // MTN-Irancell ایرانسل
'rightel'   // Rightel رایتل
'shatel'    // Shatel Mobile شاتل موبایل
```
