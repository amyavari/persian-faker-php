# 02 Person

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
