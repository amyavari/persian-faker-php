<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\DataLoader;
use AliYavari\PersianFaker\Generator;
use PHPUnit\Framework\Attributes\Test;

/**
 * This includes integration tests
 */
final class GeneratorTest extends TestCase
{
    private GeneratorInterface $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new Generator;
    }

    #[Test]
    public function it_returns_word(): void
    {
        $loader = new DataLoader('text.words');
        $words = $loader->get(); // [...]

        $word = $this->generator->word();

        $this->assertIsString($word);
        $this->assertContains($word, $words);
    }

    #[Test]
    public function it_returns_words_as_array(): void
    {
        $words = $this->generator->words(4, false);

        $this->assertIsArray($words);
        $this->assertCount(4, $words);
    }

    #[Test]
    public function it_returns_words_as_string(): void
    {
        $words = $this->generator->words(4, true);

        $this->assertIsString($words);
        $this->assertCount(4, explode(' ', $words));
    }

    #[Test]
    public function it_returns_sentence_with_strict_number_of_words(): void
    {
        $sentence = $this->generator->sentence(50, false);

        $this->assertIsString($sentence);
        $this->assertCount(50, explode(' ', $sentence));
    }

    #[Test]
    public function it_returns_sentence_with_variable_number_of_words(): void
    {
        $runs = 10;
        $wordNumbers = [];

        for ($i = 1; $i <= $runs; $i++) {
            $sentence = $this->generator->sentence(50, true);

            $this->assertIsString($sentence);

            $wordNumbers[] = count(explode(' ', $sentence));
        }

        $this->assertGreaterThan(1, count(array_unique($wordNumbers)));
    }

    #[Test]
    public function it_returns_sentences_as_array(): void
    {
        $sentences = $this->generator->sentences(4, false);

        $this->assertIsArray($sentences);
        $this->assertCount(4, $sentences);
    }

    #[Test]
    public function it_returns_sentences_as_string(): void
    {
        $sentences = $this->generator->sentences(4, true);

        $this->assertIsString($sentences);
        $this->assertCount(4, explode('. ', $sentences));
    }

    #[Test]
    public function it_returns_paragraph_with_strict_number_of_sentences(): void
    {
        $paragraph = $this->generator->paragraph(50, false);

        $this->assertIsString($paragraph);
        $this->assertCount(50, explode('. ', $paragraph));
    }

    #[Test]
    public function it_returns_paragraph_with_variable_number_of_sentences(): void
    {
        $runs = 10;
        $sentenceNumbers = [];

        for ($i = 1; $i <= $runs; $i++) {
            $paragraph = $this->generator->paragraph(50, true);

            $this->assertIsString($paragraph);

            $sentenceNumbers[] = count(explode('. ', $paragraph));
        }

        $this->assertGreaterThan(1, count(array_unique($sentenceNumbers)));
    }

    #[Test]
    public function it_returns_paragraphs_as_array(): void
    {
        $paragraphs = $this->generator->paragraphs(4, false);

        $this->assertIsArray($paragraphs);
        $this->assertCount(4, $paragraphs);
    }

    #[Test]
    public function it_returns_paragraphs_as_string(): void
    {
        $paragraphs = $this->generator->paragraphs(4, true);

        $this->assertIsString($paragraphs);
        $this->assertCount(4, explode("\n", $paragraphs));
    }

    #[Test]
    public function it_returns_text(): void
    {
        $text = $this->generator->text(300);

        $this->assertIsString($text);
        $this->assertLessThanOrEqual(300, mb_strlen($text));
    }

    #[Test]
    public function it_returns_bank_name(): void
    {
        $loader = new DataLoader('payment.bank_names');
        $banks = $loader->get(); // [...]

        $bank = $this->generator->bank();

        $this->assertIsString($bank);
        $this->assertContains($bank, $banks);
    }

    #[Test]
    public function it_returns_fake_bank_card_number(): void
    {
        $loader = new DataLoader('payment.bank_bins');
        $bankBins = $loader->get(); // ['BANK_NAME' => 'BIN']

        // Default (without separator, random bank)
        $cardNumber = $this->generator->cardNumber();

        $this->assertIsString($cardNumber);
        $this->assertSame(16, mb_strlen($cardNumber));
        $this->assertContains(mb_substr($cardNumber, 0, 6), $bankBins);

        // With separator, for specific bank
        $cardNumber = $this->generator->cardNumber('-', 'mellat');

        $this->assertIsString($cardNumber);
        $this->assertSame(19, mb_strlen($cardNumber));

        $rawCardNumber = str_replace('-', '', $cardNumber);
        $this->assertSame(16, mb_strlen($rawCardNumber));
        $this->assertSame($bankBins['mellat'], mb_substr($rawCardNumber, 0, 6));
    }

    #[Test]
    public function it_returns_fake_bank_sheba_number(): void
    {
        $loader = new DataLoader('payment.bank_sheba_codes');
        $bankCodes = $loader->get(); // ['BANK_NAME' => 'CODE']

        // Default (with IR, without separator, random bank)
        $shebaNumber = $this->generator->shebaNumber();

        $this->assertIsString($shebaNumber);
        $this->assertSame(26, mb_strlen($shebaNumber));
        $this->assertSame('IR', mb_substr($shebaNumber, 0, 2));
        $this->assertContains(mb_substr($shebaNumber, 4, 3), $bankCodes);

        // Without IR, with separator, for specific bank
        $shebaNumber = $this->generator->shebaNumber(false, '-', 'mellat');

        $this->assertIsString($shebaNumber);
        $this->assertSame(30, mb_strlen($shebaNumber));
        $this->assertNotEquals('IR', mb_substr($shebaNumber, 0, 2));

        $rawShebaNumber = str_replace('-', '', $shebaNumber);
        $this->assertSame(24, mb_strlen($rawShebaNumber));
        $this->assertSame($bankCodes['mellat'], mb_substr($rawShebaNumber, 2, 3));
    }

    #[Test]
    public function it_returns_slug_with_strict_number_of_words(): void
    {
        $slug = $this->generator->slug(50, false);

        $this->assertIsString($slug);
        $this->assertCount(50, explode('-', $slug));
    }

    #[Test]
    public function it_returns_slug_with_variable_number_of_words(): void
    {
        $runs = 10;
        $wordNumbers = [];

        for ($i = 1; $i <= $runs; $i++) {
            $slug = $this->generator->slug(50, true);

            $this->assertIsString($slug);

            $wordNumbers[] = count(explode('-', $slug));
        }

        $this->assertGreaterThan(1, count(array_unique($wordNumbers)));
    }
}
