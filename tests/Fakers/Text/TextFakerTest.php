<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\TextFaker;
use Mockery;
use Tests\TestCase;

class TextFakerTest extends TestCase
{
    use Randomable;

    protected $loader;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->andReturn(['test', 'test', 'test', 'test']);
    }

    public function test_chars_number_validation_passes_when_the_number_is_in_valid_range(): void
    {
        $number = random_int(10, 1000);

        $faker = new TextFaker($this->loader, maxNbChars: $number);
        $isValid = $this->callProtectedMethod($faker, 'isCharsNumberValid');

        $this->assertTrue($isValid);
    }

    public function test_chars_number_validation_fails_when_the_number_is_in_valid_range(): void
    {
        $number = $this->getOneRandomElement([-1, 9, 1001]);

        $faker = new TextFaker($this->loader, maxNbChars: $number);
        $isValid = $this->callProtectedMethod($faker, 'isCharsNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_it_calculates_minimum_number_of_words(): void
    {
        $faker = new TextFaker($this->loader, maxNbChars: 49);
        $minNumber = $this->callProtectedMethod($faker, 'getMinNumberOfWords');

        $this->assertIsInt($minNumber);
        $this->assertEquals(4, $minNumber); // Considers word and space are 10 chars as max.
    }

    public function test_it_says_final_text_size_is_within_char_limit_when_total_text_size_of_array_elements_is_less_than_it(): void
    {
        $words = ['one', 'two'];

        $faker = new TextFaker($this->loader, maxNbChars: 7); // With space between words
        $isWithin = $this->callProtectedMethod($faker, 'isWithinCharLimit', [$words]);

        $this->assertTrue($isWithin);
    }

    public function test_it_says_final_text_size_is_not_within_char_limit_when_total_text_size_of_array_elements_is_greater_than_it(): void
    {
        $words = ['one', 'two'];

        $faker = new TextFaker($this->loader, maxNbChars: 6); // With space between words
        $isWithin = $this->callProtectedMethod($faker, 'isWithinCharLimit', [$words]);

        $this->assertFalse($isWithin);
    }

    public function test_it_removes_last_word_in_array(): void
    {
        $words = ['one', 'two', 'three'];

        $faker = new TextFaker($this->loader, maxNbChars: 6); // With space between words
        $newWords = $this->callProtectedMethod($faker, 'removeExtraWord', [$words]);

        $this->assertIsArray($newWords);
        $this->assertEquals(['one', 'two'], $newWords);
    }

    public function test_it_returns_fake_text_with_limited_characters(): void
    {
        $number = random_int(100, 300);

        $faker = new TextFaker($this->loader, maxNbChars: $number);
        $text = $faker->generate();

        $this->assertIsString($text);
        $this->assertLessThanOrEqual($number, strlen($text));
        $this->assertGreaterThan($number - strlen(' test'), strlen($text));
    }

    public function test_it_throws_an_exception_if_char_number_is_not_between_10_and_1000(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of chars should be in range 10-1000, 9 is given.');

        $faker = new TextFaker($this->loader, maxNbChars: 9);
        $faker->generate();
    }
}
