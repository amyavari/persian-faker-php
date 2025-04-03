<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\SentenceFaker;
use AliYavari\PersianFaker\Fakers\Text\WordFaker;
use Mockery;
use ReflectionClass;
use Tests\TestCase;

class SentenceFakerTest extends TestCase
{
    use Randomable;

    protected $wordFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wordFaker = Mockery::mock(WordFaker::class);
    }

    public function test_word_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $number = random_int(1, 100);

        $faker = new SentenceFaker($this->wordFaker, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isWordsNumberValid');

        $this->assertTrue($isValid);
    }

    public function test_word_number_validation_fails_when_number_is_in_valid_range(): void
    {
        $number = $this->getOneRandomElement([-1, 0, 101]);

        $faker = new SentenceFaker($this->wordFaker, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isWordsNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_sentence_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $number = random_int(1, 100);

        $faker = new SentenceFaker($this->wordFaker, nbSentences: $number);
        $isValid = $this->callProtectedMethod($faker, 'isSentencesNumberValid');

        $this->assertTrue($isValid);
    }

    public function test_sentence_number_validation_fails_when_number_is_in_valid_range(): void
    {
        $number = $this->getOneRandomElement([-1, 0, 101]);

        $faker = new SentenceFaker($this->wordFaker, nbSentences: $number);
        $isValid = $this->callProtectedMethod($faker, 'isSentencesNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_number_with_variable_in_correct_range(): void
    {
        $faker = new SentenceFaker($this->wordFaker, nbWords: 7);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertGreaterThanOrEqual(4, $number); // 7-40%
        $this->assertLessThanOrEqual(10, $number); // 7+40%
    }

    public function test_it_returns_number_with_variable(): void
    {
        $runs = 10;
        $results = [];

        $faker = new SentenceFaker($this->wordFaker, nbWords: 50);

        for ($i = 1; $i <= $runs; $i++) {
            $results[] = $this->callProtectedMethod($faker, 'getVariableWordsNumber');
        }

        $this->assertGreaterThan(1, count(array_unique($results)));
    }

    public function test_it_returns_min_valid_number_as_variable_number_if_calculated_number_is_less_than_it(): void
    {
        $faker = new SentenceFaker($this->wordFaker, nbWords: 0);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertSame(1, $number); // Min is 1
    }

    public function test_it_returns_max_valid_number_as_variable_number_if_calculated_number_is_greater_than_it(): void
    {
        $faker = new SentenceFaker($this->wordFaker, nbWords: 200);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertSame(100, $number); // Max is 100
    }

    public function test_it_adds_dot_at_the_end_of_a_sentence(): void
    {
        $faker = new SentenceFaker($this->wordFaker);
        $sentence = $this->callProtectedMethod($faker, 'addDotAtTheEnd', ['This is a test sentence']);

        $this->assertIsString($sentence);
        $this->assertSame('This is a test sentence.', $sentence);
    }

    public function test_it_returns_multiple_words_as_sentence(): void
    {
        $number = random_int(1, 9);

        $this->wordFaker->shouldReceive('shouldReturnString')->once()->with($number)->andReturn($this->wordFaker);
        $this->wordFaker->shouldReceive('generate')->once()->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker);
        $sentence = $this->callProtectedMethod($faker, 'getSentence', [$number]);

        $this->assertIsString($sentence);
        $this->assertSame('This is test sentence.', $sentence);
        $this->assertSame('.', substr($sentence, -1));
    }

    public function test_it_returns_fake_sentences_with_strict_number_of_words(): void
    {
        $this->wordFaker->shouldReceive('shouldReturnString')->times(2)->with(50)->andReturn($this->wordFaker);
        $this->wordFaker->shouldReceive('generate')->times(2)->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker, nbWords: 50, nbSentences: 2, variableNbWords: false);
        $sentences = $this->callProtectedMethod($faker, 'getRandomSentences');

        $this->assertIsArray($sentences);
        $this->assertCount(2, $sentences);
    }

    public function test_it_returns_fake_sentence_with_variable_number_of_words(): void
    {
        /*
        / Each time shouldReturnString() is called, it gets different number as its argument.
        */
        $passedArgs = [];

        $this->wordFaker->shouldReceive('shouldReturnString')->times(10)->withArgs(function ($arg) use (&$passedArgs) {
            $passedArgs[] = $arg;

            return true;
        })->andReturn($this->wordFaker);

        $this->wordFaker->shouldReceive('generate')->times(10)->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker, nbWords: 50, nbSentences: 10, variableNbWords: true);
        $sentences = $this->callProtectedMethod($faker, 'getRandomSentences');

        $this->assertGreaterThan(1, count(array_unique($passedArgs)));
        $this->assertIsArray($sentences);
        $this->assertCount(10, $sentences);
    }

    public function test_it_says_output_should_be_text_if_number_equals_to_one(): void
    {
        $faker = new SentenceFaker($this->wordFaker, nbSentences: 1);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_be_text_if_as_text_is_true(): void
    {
        $faker = new SentenceFaker($this->wordFaker, nbSentences: 3, asText: true);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_not_be_text_if_as_text_is_false_with_number_greater_than_one(): void
    {
        $faker = new SentenceFaker($this->wordFaker, nbSentences: 3, asText: false);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertFalse($shouldBeText);
    }

    public function test_it_returns_one_fake_sentence(): void
    {
        $this->wordFaker->shouldReceive('shouldReturnString')->once()->andReturn($this->wordFaker);
        $this->wordFaker->shouldReceive('generate')->once()->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker);
        $sentence = $faker->generate();

        $this->assertIsString($sentence);
        $this->assertSame('This is test sentence.', $sentence);
    }

    public function test_it_returns_fake_sentences_as_an_array(): void
    {
        $this->wordFaker->shouldReceive('shouldReturnString')->times(4)->andReturn($this->wordFaker);
        $this->wordFaker->shouldReceive('generate')->times(4)->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker, nbSentences: 4);
        $sentences = $faker->generate();

        $this->assertIsArray($sentences);
        $this->assertCount(4, $sentences);
    }

    public function test_it_returns_fake_sentences_as_a_string(): void
    {
        $this->wordFaker->shouldReceive('shouldReturnString')->times(4)->andReturn($this->wordFaker);
        $this->wordFaker->shouldReceive('generate')->times(4)->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker, nbSentences: 4, asText: true);
        $sentences = $faker->generate();

        $this->assertIsString($sentences);
        $this->assertCount(4, explode('. ', $sentences));
    }

    public function test_it_throws_an_exception_if_sentences_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of sentences should be in range 1-100, 0 is given.');

        $faker = new SentenceFaker($this->wordFaker, nbSentences: 0);
        $faker->generate();
    }

    public function test_it_throws_an_exception_if_words_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of words should be in range 1-100, 0 is given.');

        $faker = new SentenceFaker($this->wordFaker, nbWords: 0);
        $faker->generate();
    }

    public function test_it_returns_new_instance_with_configs_to_return_as_string_with_custom_sentences_number_and_variable_words_number(): void
    {
        $this->wordFaker->shouldReceive('shouldReturnString')->andReturn($this->wordFaker);
        $this->wordFaker->shouldReceive('generate')->andReturn('This is test sentence');

        $faker = new SentenceFaker($this->wordFaker);
        $newFaker = $faker->shouldReturnString(10, 2);

        $this->assertInstanceOf(SentenceFaker::class, $newFaker);

        $reflectedSentenceFaker = new ReflectionClass(SentenceFaker::class);
        $this->assertTrue($reflectedSentenceFaker->getProperty('variableNbWords')->getValue($newFaker));
        $this->assertTrue($reflectedSentenceFaker->getProperty('asText')->getValue($newFaker));
        $this->assertSame(10, $reflectedSentenceFaker->getProperty('nbWords')->getValue($newFaker));
        $this->assertSame(2, $reflectedSentenceFaker->getProperty('nbSentences')->getValue($newFaker));
    }
}
