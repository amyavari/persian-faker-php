<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\WordFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionClass;
use Tests\TestCase;

class WordFakerTest extends TestCase
{
    protected $loader;

    protected array $words = ['text', 'a', 'by', 'tree', 'did', 'polish', 'PHP', 'application', 'an'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->words)->byDefault();
    }

    public function test_it_returns_specific_number_of_words(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 8);
        $words = $this->callProtectedMethod($faker, 'getWords');

        $this->assertIsArray($words);
        $this->assertCount(8, $words);
    }

    public function test_it_says_output_should_be_text_if_number_equals_to_one(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 1);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_be_text_if_as_text_is_true(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 3, asText: true);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_not_be_text_if_as_text_is_false_with_number_greater_than_one(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 2, asText: false);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertFalse($shouldBeText);
    }

    public function test_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 99);
        $isValid = $this->callProtectedMethod($faker, 'isNumberValid');

        $this->assertTrue($isValid);
    }

    #[DataProvider('wordNumberValidationRangeProvider')]
    public function test_number_validation_fails_when_number_is_not_in_valid_range(int $number): void
    {
        $faker = new WordFaker($this->loader, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_one_fake_word(): void
    {
        $faker = new WordFaker($this->loader);
        $word = $faker->generate();

        $this->assertIsString($word);
        $this->assertContains($word, $this->words);
    }

    public function test_it_returns_fake_words_as_array(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 3);
        $words = $faker->generate();

        $this->assertIsArray($words);
        $this->assertCount(3, $words);

        foreach ($words as $word) {
            $this->assertContains($word, $this->words);
        }
    }

    public function test_it_returns_fake_words_as_sentence(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 3, asText: true);
        $words = $faker->generate();

        $this->assertIsString($words);
        $this->assertCount(3, explode(' ', $words));
    }

    public function test_it_throws_an_exception_if_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number should be in range 1-100, 0 is given.');

        $faker = new WordFaker($this->loader, nbWords: 0);
        $faker->generate();
    }

    public function test_it_returns_new_instance_with_configs_to_return_as_string_with_custom_words_number(): void
    {
        $this->loader->shouldReceive('get')->twice()->andReturn($this->words);

        $faker = new WordFaker($this->loader, nbWords: 2, asText: false);
        $newFaker = $faker->shouldReturnString(5);

        $this->assertInstanceOf(WordFaker::class, $newFaker);

        $reflectedWordFaker = new ReflectionClass(WordFaker::class);
        $this->assertTrue($reflectedWordFaker->getProperty('asText')->getValue($newFaker));
        $this->assertSame(5, $reflectedWordFaker->getProperty('nbWords')->getValue($newFaker));
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [int $number]`
     */
    public static function wordNumberValidationRangeProvider(): iterable
    {
        yield 'greater_than_100' => [101];

        yield 'zero' => [0];

        yield 'negative' => [-1];
    }
}
