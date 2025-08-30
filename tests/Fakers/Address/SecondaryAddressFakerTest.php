<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\SecondaryAddressFaker;
use Mockery;
use Tests\TestCase;

final class SecondaryAddressFakerTest extends TestCase
{
    protected $loader;

    protected array $secondaryAddPrefixes = ['floor', 'unit', 'building'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->secondaryAddPrefixes);
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
        $secondaryAddress = $faker->generate(); // Expected format: floor 12

        [$prefix, $number] = explode(' ', $secondaryAddress);

        $this->assertIsString($secondaryAddress);
        $this->assertContains($prefix, $this->secondaryAddPrefixes);
        $this->assertIsNumeric($number);
    }
}
