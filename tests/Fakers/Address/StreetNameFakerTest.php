<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\StreetNameFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class StreetNameFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $streetNames;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('address.street_names');

        $this->streetNames = $this->loader->get();
    }

    public function test_it_returns_fake_street_name(): void
    {
        $faker = new StreetNameFaker($this->loader);
        $streetName = $faker->generate();

        $this->assertIsString($streetName);
        $this->assertContains($streetName, $this->streetNames);
    }
}
