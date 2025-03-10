<?php

declare(strict_types=1);

namespace Tests\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Payment\BankNameFaker;
use Mockery;
use Tests\TestCase;

class BankNameFakerTest extends TestCase
{
    protected $loader;

    protected array $banks = ['bank1', 'bank2', 'bank3', 'bank4'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->banks);
    }

    public function test_it_returns_fake_bank_name(): void
    {
        $faker = new BankNameFaker($this->loader);
        $bank = $faker->generate();

        $this->assertIsString($bank);
        $this->assertContains($bank, $this->banks);
    }
}
