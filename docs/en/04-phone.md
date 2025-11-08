# 04 Phone

## Table of Contents

-   [statePhonePrefix](#statephoneprefix)
-   [phoneNumber](#phonenumber)
-   [cellPhone](#cellphone)

## statePhonePrefix

Generates a random state phone prefix in Iran.

**Note:** This is a new method that does not exist in the original [fakerphp/faker](https://fakerphp.org/)

```php
echo $persianFaker->statePhonePrefix();
// '035', '021', '013'
```

## phoneNumber

Generates a random phone number in Iran.

**Note:** This method has been modified to include optional arguments. It accepts `$separator`, which defines the separator between the state prefix and the phone number (default:`''`), and `$state`, which allows generating phone numbers with a specific state prefix (default:`null`).

```php
echo $persianFaker->phoneNumber();
// '03512345678', '02112345678'

echo $persianFaker->phoneNumber(state: 'yazd');
// '03512345678', '03587654321'

echo $persianFaker->phoneNumber(separator: '-');
// '035-12345678', '021-12345678'

echo $persianFaker->phoneNumber(separator: ' ', state: 'gilan');
// '013 12345678', '013 87654321'


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

## cellPhone

Generates a random cell phone number in Iran.

**Note:** This is a new method that does not exist in the original [fakerphp/faker](https://fakerphp.org/)  
It accepts `$separator`, which defines the separator between the mobile provider prefix, the first three digits, and the last four digits of the phone number (default:`''`), and `$provider`, which allows generating phone numbers with a specific provider prefix (default:`null`).

```php
echo $persianFaker->cellPhone();
// '09121234567', '09301234567'

echo $persianFaker->cellPhone(provider: 'mtn');
// '09301234567', '09391234567'

echo $persianFaker->cellPhone(separator: '-');
// '0912-123-4567', '0930-123-4567'

echo $persianFaker->cellPhone(separator: ' ', provider: 'mci');
// '0912 123 4567', '0990 123 4567'


// Mobile provider name guide for Iran:
'mci'       // IR-MCI همراه اول
'mtn'       // MTN-Irancell ایرانسل
'rightel'   // Rightel رایتل
'shatel'    // Shatel Mobile شاتل موبایل
```
