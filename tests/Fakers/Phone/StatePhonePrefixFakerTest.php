<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Phone\StatePhonePrefixFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class StatePhonePrefixFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $phonePrefixes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('phone.state_prefixes');

        $this->phonePrefixes = $this->loader->get();
    }

    public function test_it_returns_fake_state_prefix(): void
    {
        $faker = new StatePhonePrefixFaker($this->loader);
        $phonePrefix = $faker->generate();

        $this->assertIsString($phonePrefix);
        $this->assertContains($phonePrefix, $this->phonePrefixes);
    }
}
