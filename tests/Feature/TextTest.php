<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;

it('returns a word from the data file', function (): void {
    expect(persian_faker()->word())
        ->toBeIn(fakerData('text.words'));
});

it('returns three words as an array by default', function (): void {
    expect(persian_faker()->words())
        ->toBeArray()
        ->toHaveCount(3)
        ->each->toBeIn(fakerData('text.words'));
});

it('returns the given number of words', function (): void {
    expect(persian_faker()->words(nb: 5))
        ->toBeArray()
        ->toHaveCount(5);
});

it('returns words as text', function (): void {
    $words = persian_faker()->words(nb: 5, asText: true);

    expect($words)
        ->toBeString();

    expect(wordCount($words))
        ->toBe(5);
});

it('returns one word as text', function (): void {
    expect(persian_faker()->words(nb: 1))
        ->toBeString();
});

it('throws an exception for a number of words out of range', function (int $count): void {
    expect(fn (): array|string => persian_faker()->words(nb: $count))
        ->toThrow(InvalidElementNumberException::class, "The number should be in range 1-100, {$count} is given.");
})->with('counts out of range');

it('returns a sentence of about six words by default', function (): void {
    $sentence = persian_faker()->sentence();

    expect($sentence)
        ->toBeString()
        ->toEndWith('.');

    expect(splitWords($sentence))
        ->each->toBeIn(fakerData('text.words'));

    expect(wordCount($sentence))
        ->toBeBetween(3, 8); // 6 words, 40% more or less
});

it('returns a sentence of exactly six words when the count is not variable', function (): void {
    $sentence = persian_faker()->sentence(variableNbWords: false);

    expect($sentence)
        ->toBeString()
        ->toEndWith('.');

    expect(splitWords($sentence))
        ->each->toBeIn(fakerData('text.words'));

    expect(wordCount($sentence))
        ->toBe(6);
});

it('returns a sentence of about the given number of words', function (): void {
    $sentence = persian_faker()->sentence(nbWords: 50);

    expect(wordCount($sentence))
        ->toBeBetween(30, 70); // 50 words, 40% more or less
})->repeat(20); // One run can miss a number out of range

it('changes the number of words in a sentence between calls', function (): void {
    // `->repeat()` runs are separate, so the calls are made here to compare them
    $wordCounts = [];

    for ($i = 1; $i <= 20; $i++) {
        $wordCounts[] = wordCount(persian_faker()->sentence(nbWords: 50));
    }

    expect(array_unique($wordCounts))
        ->not->toHaveCount(1);
});

it('returns a sentence of exactly the given number of words', function (): void {
    $sentence = persian_faker()->sentence(nbWords: 50, variableNbWords: false);

    expect(wordCount($sentence))
        ->toBe(50);
});

it('keeps the variable number of words in a sentence from 1 to 100', function (): void {
    $oneWordSentence = persian_faker()->sentence(nbWords: 1);

    expect(wordCount($oneWordSentence))
        ->toBeGreaterThanOrEqual(1); // 40% less is 0, so it becomes 1

    $hundredWordSentence = persian_faker()->sentence(nbWords: 100);

    expect(wordCount($hundredWordSentence))
        ->toBeLessThanOrEqual(100); // 40% more is 140, so it becomes 100
})->repeat(20); // One run can miss a number out of range

it('throws an exception for a sentence with a number of words out of range', function (int $count): void {
    expect(fn (): string => persian_faker()->sentence(nbWords: $count))
        ->toThrow(InvalidElementNumberException::class, "The number of words should be in range 1-100, {$count} is given.");
})->with('counts out of range');

it('returns three sentences as an array by default', function (): void {
    expect(persian_faker()->sentences())
        ->toBeArray()
        ->toHaveCount(3)
        ->each->toBeString()->toEndWith('.');
});

it('returns the given number of sentences', function (): void {
    expect(persian_faker()->sentences(nb: 5))
        ->toBeArray()
        ->toHaveCount(5);
});

it('returns sentences as text', function (): void {
    $sentences = persian_faker()->sentences(nb: 5, asText: true);

    expect($sentences)
        ->toBeString();

    expect(sentenceCount($sentences))
        ->toBe(5);
});

it('returns one sentence as text', function (): void {
    expect(persian_faker()->sentences(nb: 1))
        ->toBeString();
});

it('throws an exception for a number of sentences out of range', function (int $count): void {
    expect(fn (): array|string => persian_faker()->sentences(nb: $count))
        ->toThrow(InvalidElementNumberException::class, "The number of sentences should be in range 1-100, {$count} is given.");
})->with('counts out of range');

it('returns a paragraph of about three sentences by default', function (): void {
    $paragraph = persian_faker()->paragraph();

    expect($paragraph)
        ->toBeString()
        ->toEndWith('.');

    expect(splitWords($paragraph))
        ->each->toBeIn(fakerData('text.words'));

    expect(sentenceCount($paragraph))
        ->toBeBetween(1, 4); // 3 sentences, 40% more or less
});

it('returns a paragraph of exactly three sentences when the count is not variable', function (): void {
    $paragraph = persian_faker()->paragraph(variableNbSentences: false);

    expect($paragraph)
        ->toBeString()
        ->toEndWith('.');

    expect(splitWords($paragraph))
        ->each->toBeIn(fakerData('text.words'));

    expect(sentenceCount($paragraph))
        ->toBe(3);
});

it('returns a paragraph of about the given number of sentences', function (): void {
    $paragraph = persian_faker()->paragraph(nbSentences: 50);

    expect(sentenceCount($paragraph))
        ->toBeBetween(30, 70); // 50 sentences, 40% more or less
})->repeat(20); // One run can miss a number out of range

it('changes the number of sentences in a paragraph between calls', function (): void {
    // `->repeat()` runs are separate, so the calls are made here to compare them
    $sentenceCounts = [];

    for ($i = 1; $i <= 20; $i++) {
        $sentenceCounts[] = sentenceCount(persian_faker()->paragraph(nbSentences: 50));
    }

    expect(array_unique($sentenceCounts))
        ->not->toHaveCount(1);
});

it('returns a paragraph of exactly the given number of sentences', function (): void {
    $paragraph = persian_faker()->paragraph(nbSentences: 50, variableNbSentences: false);

    expect(sentenceCount($paragraph))
        ->toBe(50);
});

it('keeps the variable number of sentences in a paragraph from 1 to 100', function (): void {
    $oneSentenceParagraph = persian_faker()->paragraph(nbSentences: 1);

    expect(sentenceCount($oneSentenceParagraph))
        ->toBeGreaterThanOrEqual(1); // 40% less is 0, so it becomes 1

    $hundredSentenceParagraph = persian_faker()->paragraph(nbSentences: 100);

    expect(sentenceCount($hundredSentenceParagraph))
        ->toBeLessThanOrEqual(100); // 40% more is 140, so it becomes 100
})->repeat(20); // One run can miss a number out of range

it('throws an exception for a paragraph with a number of sentences out of range', function (int $count): void {
    expect(fn (): string => persian_faker()->paragraph(nbSentences: $count))
        ->toThrow(InvalidElementNumberException::class, "The number of sentences should be in range 1-100, {$count} is given.");
})->with('counts out of range');

it('returns three paragraphs as an array by default', function (): void {
    expect(persian_faker()->paragraphs())
        ->toBeArray()
        ->toHaveCount(3)
        ->each->toBeString()->toEndWith('.');
});

it('returns the given number of paragraphs', function (): void {
    expect(persian_faker()->paragraphs(nb: 5))
        ->toBeArray()
        ->toHaveCount(5);
});

it('returns paragraphs as text', function (): void {
    $paragraphs = persian_faker()->paragraphs(nb: 5, asText: true);

    expect($paragraphs)
        ->toBeString();

    expect(paragraphCount($paragraphs))
        ->toBe(5);
});

it('returns one paragraph as text', function (): void {
    expect(persian_faker()->paragraphs(nb: 1))
        ->toBeString();
});

it('throws an exception for a number of paragraphs out of range', function (int $count): void {
    expect(fn (): array|string => persian_faker()->paragraphs(nb: $count))
        ->toThrow(InvalidElementNumberException::class, "The number of paragraphs should be in range 1-100, {$count} is given.");
})->with('counts out of range');

it('returns a text of at most 200 characters by default', function (): void {
    $text = persian_faker()->text();

    expect($text)
        ->toBeString();

    expect(splitWords($text))
        ->each->toBeIn(fakerData('text.words'));

    expect(mb_strlen($text))
        ->toBeLessThanOrEqual(200);
});

it('returns a text of at most the given number of characters', function (): void {
    $text = persian_faker()->text(maxNbChars: 100);

    expect(mb_strlen($text))
        ->toBeLessThanOrEqual(100);
});

it('throws an exception for a text with a number of characters out of range', function (int $maxNbChars): void {
    expect(fn (): string => persian_faker()->text(maxNbChars: $maxNbChars))
        ->toThrow(InvalidElementNumberException::class, "The number of chars should be in range 10-1000, {$maxNbChars} is given.");
})->with([
    'less than 10' => ['maxNbChars' => 9],
    'more than 1000' => ['maxNbChars' => 1001],
]);

// ------------
// Helpers
// ------------

/**
 * Split a text into its words. Words are separated by one space, and the dots at the end of sentences are removed.
 *
 * @return list<string>
 */
function splitWords(string $text): array
{
    $textWithoutDots = str_replace('.', '', $text);

    return explode(' ', $textWithoutDots);
}

/**
 * Count the words in a text.
 */
function wordCount(string $text): int
{
    return count(splitWords($text));
}

/**
 * Count the sentences in a text. Each sentence ends with a dot.
 */
function sentenceCount(string $text): int
{
    return mb_substr_count($text, '.');
}

/**
 * Count the paragraphs in a text. Paragraphs are separated by a new line.
 */
function paragraphCount(string $text): int
{
    return count(explode("\n", $text));
}
