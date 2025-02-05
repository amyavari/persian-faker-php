<?php

declare(strict_types=1);

namespace Tests\Fakers;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\DataLoader;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;
use AliYavari\PersianFaker\Fakers\TitleFaker;
use PHPUnit\Framework\TestCase;

class TitleFakerTest extends TestCase
{
    /** @var DataLoaderInterface<array<string, list<string>>> */
    protected DataLoaderInterface $loader;

    /** @var list<string> */
    protected array $maleTitles;

    /** @var list<string> */
    protected array $femaleTitles;

    protected function setUp(): void
    {
        parent::setUp();

        /** @phpstan-ignore-next-line */
        $this->loader = new DataLoader('person.titles');

        [
            'male' => $this->maleTitles,
            'female' => $this->femaleTitles,
        ] = $this->loader->get();
    }

    public function test_it_returns_fake_title(): void
    {
        $titleFaker = new TitleFaker($this->loader);
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, array_merge($this->maleTitles, $this->femaleTitles));
    }

    public function test_it_returns_fake_title_for_male(): void
    {
        $titleFaker = new TitleFaker($this->loader, 'male');
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->maleTitles);
    }

    public function test_it_returns_fake_title_for_female(): void
    {
        $titleFaker = new TitleFaker($this->loader, 'female');
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->femaleTitles);
    }

    public function test_it_throws_an_exception_with_invalid_gender(): void
    {
        $this->expectException(InvalidGenderException::class);
        $this->expectExceptionMessage('The gender anonymous is not valid.');

        $titleFaker = new TitleFaker($this->loader, 'anonymous');
        $titleFaker->generate();
    }
}
