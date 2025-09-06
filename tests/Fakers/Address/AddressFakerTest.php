<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\AddressFaker;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AddressFakerTest extends TestCase
{
    private $loader;

    private array $addresses = ['address 1', 'address 4', 'address 3', 'address 2'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->addresses);
    }

    #[Test]
    public function it_returns_fake_address(): void
    {
        $faker = new AddressFaker($this->loader);
        $address = $faker->generate();

        $this->assertIsString($address);
        $this->assertContains($address, $this->addresses);
    }
}
