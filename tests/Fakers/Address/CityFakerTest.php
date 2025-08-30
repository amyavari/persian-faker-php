<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\CityFaker;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CityFakerTest extends TestCase
{
    private $loader;

    private array $cities = ['city 1', 'city 2', 'city 3', 'city 4'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->cities);
    }

    #[Test]
    public function it_returns_fake_city(): void
    {
        $faker = new CityFaker($this->loader);
        $city = $faker->generate();

        $this->assertIsString($city);
        $this->assertContains($city, $this->cities);
    }
}
