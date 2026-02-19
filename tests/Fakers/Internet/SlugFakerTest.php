<?php

declare(strict_types=1);

namespace Tests\Fakers\Internet;

use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use AliYavari\PersianFaker\Fakers\Internet\SlugFaker;
use AliYavari\PersianFaker\Fakers\Text\WordFaker;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SlugFakerTest extends TestCase
{
    private $wordFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wordFaker = Mockery::mock(WordFaker::class);
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

    #[Test]
    public function word_number_validation_passes_when_number_is_in_valid_range(): void
    {
        $faker = new SlugFaker($this->wordFaker, nbWords: 99);
        $isValid = $this->callProtectedMethod($faker, 'isWordsNumberValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    #[DataProvider('wordNumberValidationRangeProvider')]
    public function word_number_validation_fails_when_number_is_in_valid_range(int $number): void
    {
        $faker = new SlugFaker($this->wordFaker, nbWords: $number);
        $isValid = $this->callProtectedMethod($faker, 'isWordsNumberValid');

        $this->assertFalse($isValid);
    }

    #[Test]
    public function it_returns_number_with_variable_in_correct_range(): void
    {
        $faker = new SlugFaker($this->wordFaker, nbWords: 7);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertGreaterThanOrEqual(4, $number); // 7-40%
        $this->assertLessThanOrEqual(10, $number); // 7+40%
    }

    #[Test]
    public function it_returns_number_with_variable(): void
    {
        // Each time getVariableWordsNumber() is called, it returns different number.
        $runs = 10;
        $results = [];

        $faker = new SlugFaker($this->wordFaker, nbWords: 50);

        for ($i = 1; $i <= $runs; $i++) {
            $results[] = $this->callProtectedMethod($faker, 'getVariableWordsNumber');
        }

        $this->assertGreaterThan(1, count(array_unique($results)));
    }

    #[Test]
    public function it_returns_min_valid_number_as_variable_number_if_calculated_number_is_less_than_it(): void
    {
        $faker = new SlugFaker($this->wordFaker, nbWords: 0);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertSame(1, $number); // Min is 1
    }

    #[Test]
    public function it_returns_max_valid_number_as_variable_number_if_calculated_number_is_greater_than_it(): void
    {
        $faker = new SlugFaker($this->wordFaker, nbWords: 200);
        $number = $this->callProtectedMethod($faker, 'getVariableWordsNumber');

        $this->assertIsInt($number);
        $this->assertSame(100, $number); // Max is 100
    }

    #[Test]
    public function it_replaces_space_with_dash(): void
    {
        $faker = new SlugFaker($this->wordFaker);
        $slug = $this->callProtectedMethod($faker, 'replaceWordsSeparator', ['this is a test slug']);

        $this->assertIsString($slug);
        $this->assertSame('this-is-a-test-slug', $slug);
    }

    #[Test]
    public function it_returns_multiple_words_as_slug(): void
    {
        $this->wordFaker->shouldReceive('shouldReturnString')->once()->with(8)->andReturnSelf();
        $this->wordFaker->shouldReceive('generate')->once()->andReturn('this is test slug');

        $faker = new SlugFaker($this->wordFaker);
        $slug = $this->callProtectedMethod($faker, 'getSlug', [8]);

        $this->assertIsString($slug);
        $this->assertSame('this-is-test-slug', $slug);
    }

    #[Test]
    public function it_returns_one_fake_slug_with_variable_number_of_words(): void
    {
        // Each time shouldReturnString() is called, it gets different number as its argument.
        $runs = 10;
        $passedArgs = [];

        $this->wordFaker->shouldReceive('shouldReturnString')->times($runs)->withArgs(function ($arg) use (&$passedArgs) {
            $passedArgs[] = $arg;

            return true;
        })->andReturnSelf();

        $this->wordFaker->shouldReceive('generate')->times($runs)->andReturn('this is test slug');

        $faker = new SlugFaker($this->wordFaker, nbWords: 50);

        $slugs = [];
        for ($i = 1; $i <= $runs; $i++) {
            $slugs[] = $faker->generate();
        }

        $this->assertGreaterThan(1, count(array_unique($passedArgs)));
    }

    #[Test]
    public function it_returns_one_fake_slug_with_strict_number_of_words(): void
    {
        $runs = 2;

        $this->wordFaker->shouldReceive('shouldReturnString')->times(2)->with(50)->andReturnSelf();

        $this->wordFaker->shouldReceive('generate')->times(2)->andReturn('this is test slug');

        $faker = new SlugFaker($this->wordFaker, nbWords: 50, variableNbWords: false);

        for ($i = 1; $i <= $runs; $i++) {
            $slug = $faker->generate();

            $this->assertSame('this-is-test-slug', $slug);
        }
    }

    #[Test]
    public function it_throws_an_exception_if_words_number_is_not_between_one_and_100(): void
    {
        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of words should be in range 1-100, 0 is given.');

        $faker = new SlugFaker($this->wordFaker, nbWords: 0);
        $faker->generate();
    }
}
