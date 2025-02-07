<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\StateFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Tests\TestCase;

class StateFakerTest extends TestCase
{
    protected DataLoaderInterface $loader;

    protected array $states;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = new DataLoader('address.states');

        $this->states = $this->loader->get();
    }

    public function test_it_returns_fake_state(): void
    {
        $faker = new StateFaker($this->loader);
        $state = $faker->generate();

        $this->assertIsString($state);
        $this->assertContains($state, $this->states);
    }
}
