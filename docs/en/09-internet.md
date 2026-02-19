# 09 Slug

## Table of Contents

- [slug](#slug)

## slug

Generates a random slug. The number of words in the slug can be specified using the `$nbWords` parameter (default:`6`). The length of the slug can either be fixed or allowed to vary slightly (default). To enforce a strict word count, set the `$variableNbWords` parameter to `false`.

```php
echo $persianFaker->slug();
// 'نگاه-تصویر-برق-اتوبوس', 'کلاس-صادق-کاغذ-انگور-ساز-روز'

echo $persianFaker->slug(nbWords: 4);
// 'خیانت-شفق-سکوت-گیاه-آشپزخانه', 'دکتر-سبزی-مادیات'

echo $persianFaker->slug(nbWords: 4, variableNbWords: false);
// 'نگاه-تصویر-برق-اتوبوس' ,'خیانت-شفق-سکوت-گیاه'
```
