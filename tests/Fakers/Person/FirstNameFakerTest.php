<?php

declare(strict_types=1);

namespace Tests\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;
use AliYavari\PersianFaker\Fakers\Person\FirstNameFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use PHPUnit\Framework\TestCase;

class FirstNameFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $maleNames;

    protected array $femaleNames;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('person.first_names');

        [
            'male' => $this->maleNames,
            'female' => $this->femaleNames,
        ] = $this->loader->get();
    }

    public function test_it_returns_fake_first_name(): void
    {
        $faker = new FirstNameFaker($this->loader);
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, array_merge($this->maleNames, $this->femaleNames));
    }

    public function test_it_returns_fake_male_first_name(): void
    {

        $faker = new FirstNameFaker($this->loader, 'male');
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->maleNames);

    }

    public function test_it_returns_fake_female_first_name(): void
    {

        $faker = new FirstNameFaker($this->loader, 'female');
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->femaleNames);
    }

    public function test_it_throws_an_exception_with_invalid_gender(): void
    {
        $this->expectException(InvalidGenderException::class);
        $this->expectExceptionMessage('The gender anonymous is not valid.');

        $faker = new FirstNameFaker($this->loader, 'anonymous');
        $faker->generate();
    }
}
