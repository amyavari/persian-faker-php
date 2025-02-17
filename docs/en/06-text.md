# 06 Text and Paragraphs

## word

Generates a random word.

```php
echo $persianFaker->word();
// 'آتش', 'خاکستری', 'تا', 'و'
```

## words

Generates a random array of words. The number of words returned can be specified using the `$nb` parameter (default:`3`). Optionally, if `$asText` is set to `true`, a string of words will be returned instead.

```php
echo $persianFaker->words();
// ['نگاه', 'تصویر', 'برق']

echo $persianFaker->words(nb: 4);
// ['نگاه', 'تصویر', 'برق', 'اتوبوس']

echo $persianFaker->words(nb: 4, asText: true);
// 'نگاه تصویر برق اتوبوس'
```

## sentence

Generates a random sentence. The number of words in the sentence can be specified using the `$nbWords` parameter (default:`6`). The length of the sentence can either be fixed or allowed to vary slightly (default). To enforce a strict word count, set the `$variableNbWords` parameter to `false`.

```php
echo $persianFaker->sentence();
// 'نگاه تصویر برق اتوبوس', 'کلاس صادق کاغذ انگور ساز روز.'

echo $persianFaker->sentence(nbWords: 4);
// 'خیانت شفق سکوت گیاه آشپزخانه.', 'دکتر سبزی مادیات.'

echo $persianFaker->sentence(nbWords: 4, variableNbWords: false);
// 'نگاه تصویر برق اتوبوس' ,'خیانت شفق سکوت گیاه.'
```

## sentences

Generates a random array of sentences. The number of sentences returned can be specified using the `$nb` parameter (default:`3`). Optionally, if `$asText` is set to `true`, a string of sentences will be returned instead.

```php
echo $persianFaker->sentences();
// ['وزن انگور زیرا شب صبح کار.', 'جوان هنوز مدبر سکه که زعفران.', 'سیستم تنها نسیم نوشابه ادراک فضا ابر اهل.']

echo $persianFaker->sentences(nb: 2);
// ['وزن انگور زیرا شب صبح کار.', 'جوان هنوز مدبر سکه که زعفران.']

echo $persianFaker->sentences(nb: 2, asText: true);
// 'وزن انگور زیرا شب صبح کار. جوان هنوز مدبر سکه که زعفران.'
```

## paragraph

Generates a random paragraph. The number of sentences in the paragraph can be specified using the `$nbSentences` parameter (default:`3`). The length of the paragraph can either be fixed or allowed to vary slightly (default). To enforce a strict sentence count, set the `$variableNbSentences` parameter to `false`.

```php
echo $persianFaker->paragraph();
// 'وزن انگور زیرا شب صبح کار. جوان هنوز مدبر سکه که زعفران. سیستم تنها نسیم نوشابه ادراک فضا ابر اهل.'

echo $persianFaker->paragraph(nbSentences: 4);
// 'دست بازار اعتبار ارزش پل. هوش باد رادیو سبز دلبستگی. بدون کتاب زهره سیستم صندلی ماهیگیر. فکر چون تاج مهم خانه. نقاشی سایه چمن بیعت راهنما.'

echo $persianFaker->paragraph(nbSentences: 4, variableNbSentences: false);
// 'آرام آتش بیمارستان. زرد قدرت خیانت شکلات. احساس پس گرم داروخانه داور. خیابان اولویت برگ هدف عملکرد نور بدون فریاد.'
```

## paragraphs

Generates a random array of paragraphs. The number of paragraphs returned can be specified using the `$nb` parameter (default:`3`). Optionally, if `$asText` is set to `true`, a string of paragraphs will be returned instead.

```php
echo $persianFaker->paragraphs();
// [
//  'زنجبیل میراث بزرگ کتابخانه. دامپروری لذت زنبور احسان فعالیت سکوت حسابگر. طاقت ثروت سبک ترانه عشق عشق کلاس. سلام قدرت چکیده ریتم.',
//  'احسان خیابان آب سیستم سبک اما اجاق دشمنی. تاکید بهار مفید پول. تفکر دامپروری قهوه طبیعت اشاره پدر دقیقه.',
//  'کاغذ قدرت آبی شعر زیان. خانه ذهن دانش نمایش رژیم حمام گلخانه. سمی تا ورزش مادیات.',
// ]

echo $persianFaker->paragraphs(nb: 4);
// [
//  'زنجبیل میراث بزرگ کتابخانه. دامپروری لذت زنبور احسان فعالیت سکوت حسابگر. طاقت ثروت سبک ترانه عشق عشق کلاس. سلام قدرت چکیده ریتم.',
//  'احسان خیابان آب سیستم سبک اما اجاق دشمنی. تاکید بهار مفید پول. تفکر دامپروری قهوه طبیعت اشاره پدر دقیقه.',
//  'کاغذ قدرت آبی شعر زیان. خانه ذهن دانش نمایش رژیم حمام گلخانه. سمی تا ورزش مادیات.',
//  'چاپ قهوه‌ای تولد و صرفه تفکر طرح اشاره. پرستار برج آبمیوه.',
// ]

echo $persianFaker->paragraphs(nb: 4, asText: true);
//  'زنجبیل میراث بزرگ کتابخانه. دامپروری لذت زنبور احسان فعالیت سکوت حسابگر. طاقت ثروت سبک ترانه عشق عشق کلاس. سلام قدرت چکیده ریتم.\n
//  احسان خیابان آب سیستم سبک اما اجاق دشمنی. تاکید بهار مفید پول. تفکر دامپروری قهوه طبیعت اشاره پدر دقیقه.\n
//  کاغذ قدرت آبی شعر زیان. خانه ذهن دانش نمایش رژیم حمام گلخانه. سمی تا ورزش مادیات.\n
//  چاپ قهوه‌ای تولد و صرفه تفکر طرح اشاره. پرستار برج آبمیوه.'
```

## text

Generates a random text. The maximum number of characters for the returned text can be specified using the `$maxNbChars` parameter (default:`200`).

```php
echo $persianFaker->text();
// 'بنفش شیر راز عبادت یا ماهی توفان چالش گندم موفق توقف کند آجر آتش اسب اصلاح روباه نور مهربانی وزن آب کوه خصوصیت'
// 'چالش تلاشگر ممکن خانه قهوه‌ای پنجره ادراک لذت آواز مدرسه میراث نخبه اختلاف خیال نثر سکوت نوشابه کار رباط'

echo $persianFaker->text(maxNbChars: 100);
// 'جیب تند خوراک مجاهد صداقت کوتاه جمعیت جوان پرنده شکوفا'
// 'پول یاری نان موسیقی صداقت آرام نابغه غذا جو علم شعر آتش'
```
