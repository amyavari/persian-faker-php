<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Loaders\DataLoader;
use PHPUnit\Framework\TestCase;

class LastNameFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $lastNames;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('person.last_names');

        $this->lastNames = $this->loader->get();
    }

    public function test_it_returns_fake_last_name(): void
    {
        $faker = new LastNameFaker($this->loader);
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->lastNames);
    }
}
