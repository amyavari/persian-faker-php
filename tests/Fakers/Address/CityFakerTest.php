<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\CityFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class CityFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $cities;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('address.cities');

        $this->cities = $this->loader->get();
    }

    public function test_it_returns_fake_city(): void
    {
        $faker = new CityFaker($this->loader);
        $city = $faker->generate();

        $this->assertIsString($city);
        $this->assertContains($city, $this->cities);
    }
}
