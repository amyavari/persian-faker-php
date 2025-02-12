<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Fakers\Address\CityFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Mockery;
use Tests\TestCase;

class CityFakerTest extends TestCase
{
    protected $loader;

    protected array $cities = ['city 1', 'city 2', 'city 3', 'city 4'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoader::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->cities);
    }

    public function test_it_returns_fake_city(): void
    {
        $faker = new CityFaker($this->loader);
        $city = $faker->generate();

        $this->assertIsString($city);
        $this->assertContains($city, $this->cities);
    }
}
