<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\SentenceFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Mockery;
use Tests\TestCase;

class SentenceFakerTest extends TestCase
{
    use Randomable;

    protected $loader;

    protected array $words = ['text', 'a', 'by', 'tree', 'did', 'polish', 'PHP', 'application', 'an'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoader::class);
    }

    public function test_word_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $number = random_int(1, 100);

        $faker = new SentenceFaker($this->loader, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isWordsNumberValid');

        $this->assertTrue($isValid);
    }

    public function test_word_number_validation_fails_when_number_is_in_valid_range(): void
    {
        $number = $this->getOneRandomElement([-1, 0, 101]);

        $faker = new SentenceFaker($this->loader, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isWordsNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_sentence_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $number = random_int(1, 100);

        $faker = new SentenceFaker($this->loader, nbSentences: $number);
        $isValid = $this->callProtectedMethod($faker, 'isSentencesNumberValid');

        $this->assertTrue($isValid);
    }

    public function test_sentence_number_validation_fails_when_number_is_in_valid_range(): void
    {
        $number = $this->getOneRandomElement([-1, 0, 101]);

        $faker = new SentenceFaker($this->loader, nbSentences: $number);
        $isValid = $this->callProtectedMethod($faker, 'isSentencesNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_number_with_variable(): void
    {
        $faker = new SentenceFaker($this->loader, nbWords: 1);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertEquals(1, $number); // min is 1

        $faker = new SentenceFaker($this->loader, nbWords: 7);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertGreaterThanOrEqual(4, $number); // 7-40%
        $this->assertLessThanOrEqual(10, $number); // 7+40%

        $faker = new SentenceFaker($this->loader, nbWords: 100);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertGreaterThanOrEqual(60, $number); // 100-40%
        $this->assertLessThanOrEqual(100, $number); // 100+40% and max is 100
    }

    public function test_it_adds_dot_at_the_end_of_a_sentence(): void
    {
        $faker = new SentenceFaker($this->loader);
        $sentence = $this->callProtectedMethod($faker, 'addDotAtTheEnd', ['This is a test sentence']);

        $this->assertIsString($sentence);
        $this->assertEquals('This is a test sentence.', $sentence);
    }

    public function test_it_returns_multiple_words_as_sentence(): void
    {
        $this->loader->shouldReceive('get')->once()->andReturn($this->words);

        $number = random_int(1, 9);

        $faker = new SentenceFaker($this->loader);
        $sentence = $this->callProtectedMethod($faker, 'getSentence', [$number]);

        $this->assertIsString($sentence);
        $this->assertEquals($number, count(explode(' ', $sentence)));
        $this->assertEquals('.', substr($sentence, -1));
    }

    public function test_it_returns_fake_sentences_with_strict_number_of_words(): void
    {
        $this->loader->shouldReceive('get')->times(2)->andReturn($this->words);

        $faker = new SentenceFaker($this->loader, nbWords: 50, nbSentences: 2, variableNbWords: false);
        $sentences = $this->callProtectedMethod($faker, 'getRandomSentences');

        $this->assertEquals(2, count($sentences));
        $this->assertEquals(50, count(explode(' ', (string) $sentences[0])));
        $this->assertEquals(50, count(explode(' ', (string) $sentences[1])));
    }

    public function test_it_returns_fake_sentence_with_variable_number_of_words(): void
    {
        $this->loader->shouldReceive('get')->times(2)->andReturn($this->words);

        $faker = new SentenceFaker($this->loader, nbWords: 50, nbSentences: 2, variableNbWords: true);
        $sentences = $this->callProtectedMethod($faker, 'getRandomSentences');

        $this->assertNotEquals(count(explode(' ', (string) $sentences[0])), count(explode(' ', (string) $sentences[1])));
    }

    public function test_it_says_output_should_be_text_if_number_equals_to_one(): void
    {
        $faker = new SentenceFaker($this->loader, nbSentences: 1);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_be_text_if_as_text_is_true(): void
    {
        $faker = new SentenceFaker($this->loader, nbSentences: 3, asText: true);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_not_be_text_if_as_text_is_false_with_number_greater_than_one(): void
    {
        $faker = new SentenceFaker($this->loader, nbSentences: 3, asText: false);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertFalse($shouldBeText);
    }

    public function test_it_returns_one_fake_sentence(): void
    {
        $this->loader->shouldReceive('get')->once()->andReturn($this->words);

        $faker = new SentenceFaker($this->loader);
        $sentence = $faker->generate();

        $this->assertIsString($sentence);
        $this->assertNotEmpty($sentence);
    }

    public function test_it_returns_fake_sentences_as_an_array(): void
    {
        $this->loader->shouldReceive('get')->times(4)->andReturn($this->words);

        $faker = new SentenceFaker($this->loader, nbSentences: 4);
        $sentences = $faker->generate();

        $this->assertIsArray($sentences);
        $this->assertEquals(4, count($sentences));
    }

    public function test_it_returns_fake_sentences_as_a_string(): void
    {
        $this->loader->shouldReceive('get')->times(4)->andReturn($this->words);

        $faker = new SentenceFaker($this->loader, nbSentences: 4, asText: true);
        $sentences = $faker->generate();

        $this->assertIsString($sentences);
        $this->assertEquals(4, count(explode('. ', $sentences)));
    }

    public function test_it_throws_an_exception_if_sentences_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of sentences should be in range 1-100, 0 is given.');

        $faker = new SentenceFaker($this->loader, nbSentences: 0);
        $faker->generate();
    }

    public function test_it_throws_an_exception_if_words_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of words should be in range 1-100, 0 is given.');

        $faker = new SentenceFaker($this->loader, nbWords: 0);
        $faker->generate();
    }
}
