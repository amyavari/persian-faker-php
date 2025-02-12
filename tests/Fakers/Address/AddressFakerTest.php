<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Fakers\Address\AddressFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Mockery;
use Tests\TestCase;

class AddressFakerTest extends TestCase
{
    protected $loader;

    protected array $addresses = ['address 1', 'address 4', 'address 3', 'address 2'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoader::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->addresses);
    }

    public function test_it_returns_fake_address(): void
    {
        $faker = new AddressFaker($this->loader);
        $address = $faker->generate();

        $this->assertIsString($address);
        $this->assertContains($address, $this->addresses);
    }
}
