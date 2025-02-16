<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\WordFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Mockery;
use Tests\TestCase;

class WordFakerTest extends TestCase
{
    use Randomable;

    protected $loader;

    protected array $words = ['text', 'a', 'by', 'tree', 'did', 'polish', 'PHP', 'application', 'an'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoader::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->words);
    }

    public function test_it_returns_specific_number_of_words(): void
    {
        $number = random_int(1, 9);

        $faker = new WordFaker($this->loader, nbWords: $number);
        $words = $this->callProtectedMethod($faker, 'getWords');

        $this->assertIsArray($words);
        $this->assertEquals($number, count($words));
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

    public function test_it_makes_array_as_string_separated_by_space(): void
    {
        $faker = new WordFaker($this->loader);
        $text = $this->callProtectedMethod($faker, 'convertToText', [['one', 'two', 'a']]);

        $this->assertIsString($text);
        $this->assertEquals('one two a', $text);
    }

    public function test_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $number = random_int(1, 100);

        $faker = new WordFaker($this->loader, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isNumberValid');

        $this->assertTrue($isValid);
    }

    public function test_number_validation_fails_when_number_is_not_in_valid_range(): void
    {
        $number = $this->getOneRandomElement([-1, 0, 101]);

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
        $this->assertEquals(3, count($words));
    }

    public function test_it_returns_fake_words_as_sentence(): void
    {
        $faker = new WordFaker($this->loader, nbWords: 3, asText: true);
        $words = $faker->generate();

        $this->assertIsString($words);
        $this->assertEquals(3, count(explode(' ', $words)));
    }

    public function test_it_throws_an_exception_if_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number should be in range 1-100, 0 is given.');

        $faker = new WordFaker($this->loader, nbWords: 0);
        $faker->generate();
    }
}
