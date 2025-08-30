<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\StreetNameFaker;
use Mockery;
use Tests\TestCase;

final class StreetNameFakerTest extends TestCase
{
    protected $loader;

    protected array $streetNames = ['name one', 'name two', 'name three', 'name 4'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->streetNames);
    }

    public function test_it_returns_fake_street_name(): void
    {
        $faker = new StreetNameFaker($this->loader);
        $streetName = $faker->generate();

        $this->assertIsString($streetName);
        $this->assertContains($streetName, $this->streetNames);
    }
}
