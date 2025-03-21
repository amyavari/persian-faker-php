# 07 Payment

## bank

Generates a random bank name in Iran.

**Note:** This is a new method that does not exist in the original [fakerphp/faker](https://fakerphp.org/).

```php
echo $persianFaker->bank();
// 'قرض الحسنه مهر ایران', 'گردشگری',  'ملت', 'ملی ایران',
```

## cardNumber

Generates a random bank card number in Iran.

**Note:** This is a new method that does not exist in the original [fakerphp/faker](https://fakerphp.org/).  
It accepts `$separator`, which defines the separator between each four digits (default:`''`), and `$bank`, which allows generating card number for a specific bank (default:`null`).

```php
echo $persianFaker->cardNumber();
// '6395994370054358', '6395994370054358'

echo $persianFaker->cardNumber(separator: '-');
// '6395-9943-7005-4358', '6395-9943-7005-4358'

echo $persianFaker->cardNumber(bank: 'mellat');
// '6104336643590175', '6104337825440666'

echo $persianFaker->cardNumber(separator: ' ', bank: 'mellat');
// '6104 3366 4359 0175', '6104 3378 2544 0666'

// Bank name guide for Iran:
'melli'                // Bank Melli Iran بانک ملی ایران
'sepah'                // Bank Sepah بانک سپه
'tos_e_saderat'        // Bank Tose'e Saderat Iran بانک توسعه صادرات ایران
'sanat_madan'          // Bank Sanat va Madan بانک صنعت و معدن
'keshavarzi'           // Bank Keshavarzi بانک کشاورزی
'maskan'               // Bank Maskan بانک مسکن
'saderat'              // Bank Saderat Iran بانک صادرات ایران
'post_bank'            // Post Bank Iran پست بانک ایران
'mellat'               // Bank Mellat بانک ملت
'tejarat'              // Bank Tejarat بانک تجارت
'refah'                // Bank Refah Kargaran بانک رفاه کارگران
'parsian'              // Bank Parsian بانک پارسیان
'noor'                 // Bank Noor بانک نور
'pasargad'             // Bank Pasargad بانک پاسارگاد
'melal'                // Bank Melal بانک ملل
'ghavamin'             // Bank Ghavamin بانک قوامین
'mehr_iran'            // Bank Mehr Iran بانک مهر ایران
'karafarin'            // Bank Karafarin بانک کارآفرین
'gardeshgari'          // Bank Gardeshgari بانک گردشگری
'saman'                // Bank Saman بانک سامان
'sina'                 // Bank Sina بانک سینا
'sarmaye'              // Bank Sarmaye بانک سرمایه
'shahr'                // Bank Shahr بانک شهر
'dey'                  // Bank Dey بانک دی
'eghtesad_novin'       // Bank Eghtesad Novin بانک اقتصاد نوین
'ansar'                // Bank Ansar بانک انصار
'iran_zamin'           // Bank Iran Zamin بانک ایران زمین
'taavon'               // Bank Taavon بانک توسعه تعاون ایران
```

## shebaNumber

Generates a random bank Sheba number (IBAN) in Iran.

**Note:** This is a new method that does not exist in the original [fakerphp/faker](https://fakerphp.org/).  
It accepts `withIR`, which determines whether the output should include 'IR' `true` or not `false` (default: `true`), `$separator`, which defines the separator between the digits of the Sheba number in its standard representation (default: `''`), and `$bank`, which allows generating a card number for a specific bank (default: `null`).

```php
echo $persianFaker->shebaNumber();
// 'IR690180000608266708481840', 'IR780140000153599122279494'

echo $persianFaker->shebaNumber(withIR: false);
// '690180000608266708481840', '780140000153599122279494'

echo $persianFaker->shebaNumber(separator: '-');
// 'IR69-0180-0006-0826-6708-4818-40', 'IR78-0140-0001-5359-9122-2794-94'

echo $persianFaker->shebaNumber(bank: 'mellat');
// 'IR260120000134988390291410', 'IR290120000343374321504241'

echo $persianFaker->shebaNumber(withIR: false, separator: ' ', bank: 'mellat');
// '26 0120 0001 3498 8390 2914 10', '29 0120 0003 4337 4321 5042 41'

// Bank name guide for Iran:
'melli'                // Bank Melli Iran بانک ملی ایران
'sepah'                // Bank Sepah بانک سپه
'tos_e_saderat'        // Bank Tose'e Saderat Iran بانک توسعه صادرات ایران
'sanat_madan'          // Bank Sanat va Madan بانک صنعت و معدن
'keshavarzi'           // Bank Keshavarzi بانک کشاورزی
'maskan'               // Bank Maskan بانک مسکن
'saderat'              // Bank Saderat Iran بانک صادرات ایران
'post_bank'            // Post Bank Iran پست بانک ایران
'mellat'               // Bank Mellat بانک ملت
'tejarat'              // Bank Tejarat بانک تجارت
'refah'                // Bank Refah Kargaran بانک رفاه کارگران
'parsian'              // Bank Parsian بانک پارسیان
'noor'                 // Bank Noor بانک نور
'pasargad'             // Bank Pasargad بانک پاسارگاد
'melal'                // Bank Melal بانک ملل
'ghavamin'             // Bank Ghavamin بانک قوامین
'mehr_iran'            // Bank Mehr Iran بانک مهر ایران
'karafarin'            // Bank Karafarin بانک کارآفرین
'gardeshgari'          // Bank Gardeshgari بانک گردشگری
'saman'                // Bank Saman بانک سامان
'sina'                 // Bank Sina بانک سینا
'sarmaye'              // Bank Sarmaye بانک سرمایه
'shahr'                // Bank Shahr بانک شهر
'dey'                  // Bank Dey بانک دی
'eghtesad_novin'       // Bank Eghtesad Novin بانک اقتصاد نوین
'ansar'                // Bank Ansar بانک انصار
'iran_zamin'           // Bank Iran Zamin بانک ایران زمین
'taavon'               // Bank Taavon بانک توسعه تعاون ایران
```
