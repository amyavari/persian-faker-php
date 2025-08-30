<?php

declare(strict_types=1);

namespace Tests\Fakers\Text;

use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Text\ParagraphFaker;
use AliYavari\PersianFaker\Fakers\Text\SentenceFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class ParagraphFakerTest extends TestCase
{
    protected $sentenceFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sentenceFaker = Mockery::mock(SentenceFaker::class);
    }

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [int $number]`
     */
    public static function sentenceNumberValidationRangeProvider(): iterable
    {
        yield 'greater_than_100' => [101];

        yield 'zero' => [0];

        yield 'negative' => [-1];
    }

    /**
     * Provides datasets in the format: `dataset => [int $number]`
     */
    public static function paragraphNumberValidationRangeProvider(): iterable
    {
        yield 'greater_than_100' => [101];

        yield 'zero' => [0];

        yield 'negative' => [-1];
    }

    public function test_sentence_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 99);
        $isValid = $this->callProtectedMethod($faker, 'isSentencesNumberValid');

        $this->assertTrue($isValid);
    }

    #[DataProvider('sentenceNumberValidationRangeProvider')]
    public function test_sentence_number_validation_fails_when_number_is_in_valid_range(int $number): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: $number);
        $isValid = $this->callProtectedMethod($faker, 'isSentencesNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_paragraph_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 99);
        $isValid = $this->callProtectedMethod($faker, 'isParagraphsNumberValid');

        $this->assertTrue($isValid);
    }

    #[DataProvider('paragraphNumberValidationRangeProvider')]
    public function test_paragraph_number_validation_fails_when_number_is_in_valid_range(int $number): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: $number);
        $isValid = $this->callProtectedMethod($faker, 'isParagraphsNumberValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_number_with_variable_in_correct_range(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 7);
        $number = $this->callProtectedMethod($faker, 'getVariableSentencesNumber');

        $this->assertIsInt($number);
        $this->assertGreaterThanOrEqual(4, $number); // 7-40%
        $this->assertLessThanOrEqual(10, $number); // 7+40%
    }

    public function test_it_returns_number_with_variable(): void
    {
        // Each time getVariableSentencesNumber() is called, it returns different number.
        $runs = 10;
        $results = [];

        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 50);

        for ($i = 1; $i <= $runs; $i++) {
            $results[] = $this->callProtectedMethod($faker, 'getVariableSentencesNumber');
        }

        $this->assertGreaterThan(1, count(array_unique($results)));
    }

    public function test_it_returns_min_valid_number_as_variable_number_if_calculated_number_is_less_than_it(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 0);
        $number = $this->callProtectedMethod($faker, 'getVariableSentencesNumber');

        $this->assertIsInt($number);
        $this->assertSame(1, $number); // Min is 1
    }

    public function test_it_returns_max_valid_number_as_variable_number_if_calculated_number_is_greater_than_it(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 200);
        $number = $this->callProtectedMethod($faker, 'getVariableSentencesNumber');

        $this->assertIsInt($number);
        $this->assertSame(100, $number); // Max is 100
    }

    public function test_it_returns_multiple_sentences_as_a_paragraph(): void
    {
        $nbWords = 6; // Default number of words in each sentence

        $this->sentenceFaker->shouldReceive('shouldReturnString')->once()->with($nbWords, 8)->andReturnSelf();
        $this->sentenceFaker->shouldReceive('generate')->once()->andReturn('This is test sentence. Second sentence.');

        $faker = new ParagraphFaker($this->sentenceFaker);
        $paragraph = $this->callProtectedMethod($faker, 'getParagraph', [8]);

        $this->assertIsString($paragraph);
        $this->assertSame('This is test sentence. Second sentence.', $paragraph);
    }

    public function test_it_returns_fake_paragraphs_with_strict_number_of_sentences(): void
    {
        $nbWords = 6; // Default number of words in each sentence

        $this->sentenceFaker->shouldReceive('shouldReturnString')->times(2)->with($nbWords, 50)->andReturnSelf();
        $this->sentenceFaker->shouldReceive('generate')->times(2)->andReturn('This is test sentence. Second sentence.');

        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 50, nbParagraphs: 2, variableNbSentences: false);
        $paragraphs = $this->callProtectedMethod($faker, 'getRandomParagraphs');

        $this->assertIsArray($paragraphs);
        $this->assertCount(2, $paragraphs);

        foreach ($paragraphs as $paragraph) {
            $this->assertSame('This is test sentence. Second sentence.', $paragraph);
        }
    }

    public function test_it_returns_fake_paragraphs_with_variable_number_of_sentences(): void
    {
        // Each time shouldReturnString() is called, it gets different number of $nbSentence as its argument.
        $passedArgs = [];

        $this->sentenceFaker->shouldReceive('shouldReturnString')->times(10)->withArgs(function ($nbWords, $nbSentences) use (&$passedArgs) {
            $passedArgs[] = $nbSentences;

            return true;
        })->andReturnSelf();

        $this->sentenceFaker->shouldReceive('generate')->times(10)->andReturn('This is test sentence. Second sentence.');

        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 50, nbParagraphs: 10, variableNbSentences: true);
        $paragraphs = $this->callProtectedMethod($faker, 'getRandomParagraphs');

        $this->assertGreaterThan(1, count(array_unique($passedArgs)));
        $this->assertIsArray($paragraphs);
        $this->assertCount(10, $paragraphs);
    }

    public function test_it_says_output_should_be_text_if_number_equals_to_one(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 1);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_be_text_if_as_text_is_true(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 3, asText: true);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertTrue($shouldBeText);
    }

    public function test_it_says_output_should_not_be_text_if_as_text_is_false_with_number_greater_than_one(): void
    {
        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 3, asText: false);
        $shouldBeText = $this->callProtectedMethod($faker, 'shouldBeText');

        $this->assertFalse($shouldBeText);
    }

    public function test_it_returns_one_fake_paragraph(): void
    {
        $this->sentenceFaker->shouldReceive('shouldReturnString')->once()->andReturnSelf();
        $this->sentenceFaker->shouldReceive('generate')->once()->andReturn('This is test sentence. Second sentence.');

        $faker = new ParagraphFaker($this->sentenceFaker);
        $paragraph = $faker->generate();

        $this->assertIsString($paragraph);
        $this->assertSame('This is test sentence. Second sentence.', $paragraph);
    }

    public function test_it_returns_fake_paragraphs_as_an_array(): void
    {
        $this->sentenceFaker->shouldReceive('shouldReturnString')->times(4)->andReturnSelf();
        $this->sentenceFaker->shouldReceive('generate')->times(4)->andReturn('This is test sentence. Second sentence.');

        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 4);
        $paragraphs = $faker->generate();

        $this->assertIsArray($paragraphs);
        $this->assertCount(4, $paragraphs);
    }

    public function test_it_returns_fake_paragraphs_as_a_string(): void
    {
        $this->sentenceFaker->shouldReceive('shouldReturnString')->times(4)->andReturnSelf();
        $this->sentenceFaker->shouldReceive('generate')->times(4)->andReturn('This is test sentence. Second sentence.');

        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 4, asText: true);
        $paragraphs = $faker->generate();

        $this->assertIsString($paragraphs);
        $this->assertCount(4, explode("\n", $paragraphs));
    }

    public function test_it_throws_an_exception_if_sentences_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of sentences should be in range 1-100, 0 is given.');

        $faker = new ParagraphFaker($this->sentenceFaker, nbSentences: 0);
        $faker->generate();
    }

    public function test_it_throws_an_exception_if_paragraphs_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of paragraphs should be in range 1-100, 0 is given.');

        $faker = new ParagraphFaker($this->sentenceFaker, nbParagraphs: 0);
        $faker->generate();
    }
}
