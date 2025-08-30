<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\TextFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class TextFakerTest extends TestCase
{
    private $loader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn(['تست', 'تست', 'تست', 'تست']);
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [int $number]`
     */
    public static function charNumberValidationRangeProvider(): iterable
    {
        yield 'greater_than_1000' => [1_001];

        yield 'less_than_10' => [9];

        yield 'negative' => [-1];
    }

    public function test_chars_number_validation_passes_when_the_number_is_in_valid_range(): void
    {
        $faker = new TextFaker($this->loader, maxNbChars: 999);
        $isValid = $this->callProtectedMethod($faker, 'isCharsNumberValid');

        $this->assertTrue($isValid);
    }

    #[DataProvider('charNumberValidationRangeProvider')]
    public function test_chars_number_validation_fails_when_the_number_is_in_valid_range(int $number): void
    {
        $faker = new TextFaker($this->loader, maxNbChars: $number);
        $isValid = $this->callProtectedMethod($faker, 'isCharsNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_it_calculates_minimum_number_of_words(): void
    {
        $faker = new TextFaker($this->loader, maxNbChars: 49);
        $minNumber = $this->callProtectedMethod($faker, 'getMinNumberOfWords');

        $this->assertIsInt($minNumber);
        $this->assertSame(4, $minNumber); // Considers word and space are 10 chars as max.
    }

    public function test_it_says_final_text_size_is_within_char_limit_when_total_text_size_of_array_elements_is_less_than_it(): void
    {
        $words = ['یک', 'دو'];

        $faker = new TextFaker($this->loader, maxNbChars: 5); // With space between words
        $isWithin = $this->callProtectedMethod($faker, 'isWithinCharLimit', [$words]);

        $this->assertTrue($isWithin);
    }

    public function test_it_says_final_text_size_is_not_within_char_limit_when_total_text_size_of_array_elements_is_greater_than_it(): void
    {
        $words = ['یک', 'دو'];

        $faker = new TextFaker($this->loader, maxNbChars: 4); // With space between words
        $isWithin = $this->callProtectedMethod($faker, 'isWithinCharLimit', [$words]);

        $this->assertFalse($isWithin);
    }

    public function test_it_removes_extra_words_in_array(): void
    {
        $words = ['یک', 'دو', 'سه', 'چهار', 'پنج'];

        $faker = new TextFaker($this->loader, maxNbChars: 5); // With space between words
        $newWords = $this->callProtectedMethod($faker, 'removeExtraWords', [$words]);

        $this->assertIsArray($newWords);
        $this->assertSame(['یک', 'دو'], $newWords);
    }

    public function test_it_returns_fake_text_with_limited_characters(): void
    {
        $faker = new TextFaker($this->loader, maxNbChars: 200);
        $text = $faker->generate();

        $this->assertIsString($text);
        $this->assertSame(199, mb_strlen($text)); // Test words are 3 characters plus 1 space between words.
    }

    public function test_it_throws_an_exception_if_char_number_is_not_between_10_and_1000(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of chars should be in range 10-1000, 9 is given.');

        $faker = new TextFaker($this->loader, maxNbChars: 9);
        $faker->generate();
    }
}
