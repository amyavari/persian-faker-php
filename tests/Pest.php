<?php

declare(strict_types=1);

use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind different classes or traits.
|
*/

pest()->extend(TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Get data from a file in `src/data` using dot notation.
 * The first segment is the file name; the rest are keys inside it.
 * For example, "company.job_titles" returns the "job_titles" array of `company.php`.
 * With `$merge`, the nested arrays are merged into one array,
 * for example "person.first_names" returns the names of both genders.
 *
 * @return array<array-key, mixed>
 */
function fakerData(string $path, bool $merge = false): array
{
    $keys = explode('.', $path);
    $fileName = array_shift($keys);

    $data = require __DIR__."/../src/data/{$fileName}.php";

    foreach ($keys as $key) {
        $data = $data[$key];
    }

    if (! is_array($data)) {
        throw new UnexpectedValueException("Faker data [{$path}] is not an array.");
    }

    if ($merge) {
        foreach ($data as $key => $nestedData) {
            if (! is_array($nestedData)) {
                throw new UnexpectedValueException("Faker data [{$path}.{$key}] is not an array, so it cannot be merged.");
            }
        }

        return array_merge(...array_values($data));
    }

    return $data;
}

/**
 * Get a single value from a file in `src/data` using dot notation.
 * For example, "payment.bank_bins.melli" returns the card BIN of Melli bank.
 */
function fakerValue(string $path): string
{
    $keys = explode('.', $path);
    $valueKey = array_pop($keys);

    $data = fakerData(implode('.', $keys));

    return (string) $data[$valueKey];
}
