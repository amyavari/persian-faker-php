<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\SecondaryAddressFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class SecondaryAddressFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $secondaryAddPrefixes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('address.secondary_address_prefixes');

        $this->secondaryAddPrefixes = $this->loader->get();

    }

    public function test_it_returns_random_secondary_address_prefix(): void
    {
        $faker = new SecondaryAddressFaker($this->loader);
        $prefix = $this->callProtectedMethod($faker, 'getRandomPrefix');

        $this->assertIsString($prefix);
        $this->assertContains($prefix, $this->secondaryAddPrefixes);
    }

    public function test_it_returns_fake_secondary_address(): void
    {
        $faker = new SecondaryAddressFaker($this->loader);
        $secondaryAddress = $faker->generate();

        [$prefix,$number] = explode(' ', $secondaryAddress);

        $this->assertIsString($secondaryAddress);
        $this->assertContains($prefix, $this->secondaryAddPrefixes);
        $this->assertIsNumeric($number);
    }
}
