<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Generator;
use AliYavari\PersianFaker\Loaders\DataLoader;
use PHPUnit\Framework\TestCase;

/**
 * This includes integration tests
 */
class GeneratorTest extends TestCase
{
    use Randomable;

    protected GeneratorInterface $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new Generator;
    }

    public function test_it_returns_title(): void
    {
        $loader = new DataLoader('person.titles');
        ['male' => $maleTitles, 'female' => $femaleTitles] = $loader->get();

        $gender = $this->getOneRandomElement([null, 'male', 'female']);

        $title = $this->generator->title($gender);

        $this->assertIsString($title);
        $this->assertContains($title, array_merge($maleTitles, $femaleTitles));
    }

    public function test_it_returns_male_title(): void
    {
        $loader = new DataLoader('person.titles');
        ['male' => $maleTitles, 'female' => $femaleTitles] = $loader->get();

        $title = $this->generator->titleMale();

        $this->assertIsString($title);
        $this->assertContains($title, $maleTitles);
    }

    public function test_it_returns_female_title(): void
    {
        $loader = new DataLoader('person.titles');
        ['male' => $maleTitles, 'female' => $femaleTitles] = $loader->get();

        $title = $this->generator->titleFemale();

        $this->assertIsString($title);
        $this->assertContains($title, $femaleTitles);
    }
}
