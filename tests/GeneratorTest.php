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

    public function test_it_returns_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        ['male' => $maleNames, 'female' => $femaleNames] = $loader->get();

        $gender = $this->getOneRandomElement([null, 'male', 'female']);

        $firstName = $this->generator->firstName($gender);

        $this->assertIsString($firstName);
        $this->assertContains($firstName, array_merge($maleNames, $femaleNames));
    }

    public function test_it_returns_male_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        ['male' => $maleNames, 'female' => $femaleNames] = $loader->get();

        $firstName = $this->generator->firstNameMale();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $maleNames);
    }

    public function test_it_returns_female_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        ['male' => $maleNames, 'female' => $femaleNames] = $loader->get();

        $firstName = $this->generator->firstNameFemale();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $femaleNames);
    }

    public function test_it_returns_last_name(): void
    {
        $loader = new DataLoader('person.last_names');
        $lastNames = $loader->get();

        $lastName = $this->generator->lastName();

        $this->assertIsString($lastName);
        $this->assertContains($lastName, $lastNames);
    }

    public function test_it_returns_full_name(): void
    {
        $gender = $this->getOneRandomElement([null, 'male', 'female']);

        $name = $this->generator->name($gender);

        $this->assertIsString($name);
        $this->assertIsArray(explode(' ', $name));
    }
}
