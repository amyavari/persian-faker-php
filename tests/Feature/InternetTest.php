<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

it('returns a slug of about six words by default', function (): void {
    $slug = persian_faker()->slug();

    expect($slug)
        ->toBeString()
        ->toMatch('/^[^\s-]+(-[^\s-]+)*$/u'); // Words joined by single dashes, with no spaces

    expect(splitSlug($slug))
        ->each->toBeIn(fakerData('text.words'));

    expect(slugWordCount($slug))
        ->toBeBetween(3, 8); // 6 words, 40% more or less
});

it('returns a slug of exactly six words when the count is not variable', function (): void {
    $slug = persian_faker()->slug(variableNbWords: false);

    expect($slug)
        ->toBeString()
        ->toMatch('/^[^\s-]+(-[^\s-]+)*$/u'); // Words joined by single dashes, with no spaces

    expect(splitSlug($slug))
        ->each->toBeIn(fakerData('text.words'));

    expect(slugWordCount($slug))
        ->toBe(6);
});

it('returns a slug of about the given number of words', function (): void {
    $slug = persian_faker()->slug(nbWords: 50);

    expect(slugWordCount($slug))
        ->toBeBetween(30, 70); // 50 words, 40% more or less
})->repeat(20); // One run can miss a number out of range

it('changes the number of words in a slug between calls', function (): void {
    // `->repeat()` runs are separate, so the calls are made here to compare them
    $wordCounts = [];

    for ($i = 1; $i <= 20; $i++) {
        $wordCounts[] = slugWordCount(persian_faker()->slug(nbWords: 50));
    }

    expect(array_unique($wordCounts))
        ->not->toHaveCount(1);
});

it('returns a slug of exactly the given number of words', function (): void {
    $slug = persian_faker()->slug(nbWords: 50, variableNbWords: false);

    expect(slugWordCount($slug))
        ->toBe(50);
});

it('keeps the variable number of words in a slug from 1 to 100', function (): void {
    $oneWordSlug = persian_faker()->slug(nbWords: 1);

    expect(slugWordCount($oneWordSlug))
        ->toBeGreaterThanOrEqual(1); // 40% less is 0, so it becomes 1

    $hundredWordSlug = persian_faker()->slug(nbWords: 100);

    expect(slugWordCount($hundredWordSlug))
        ->toBeLessThanOrEqual(100); // 40% more is 140, so it becomes 100
})->repeat(20); // One run can miss a number out of range

it('throws an exception for a slug with a number of words out of range', function (int $count): void {
    expect(fn (): string => persian_faker()->slug(nbWords: $count))
        ->toThrow(InvalidElementNumberException::class, "The number of words should be in range 1-100, {$count} is given.");
})->with('counts out of range');

// ------------
// Helpers
// ------------

/**
 * Split a slug into its words. Words are separated by a dash.
 *
 * @return list<string>
 */
function splitSlug(string $slug): array
{
    return explode('-', $slug);
}

/**
 * Count the words in a slug.
 */
function slugWordCount(string $slug): int
{
    return count(splitSlug($slug));
}
