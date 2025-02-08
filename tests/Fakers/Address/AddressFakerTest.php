<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\AddressFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class AddressFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $addresses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('address.addresses');

        $this->addresses = $this->loader->get();
    }

    public function test_it_returns_fake_address(): void
    {
        $faker = new AddressFaker($this->loader);
        $address = $faker->generate();

        $this->assertIsString($address);
        $this->assertContains($address, $this->addresses);
    }
}
