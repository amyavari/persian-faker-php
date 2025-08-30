<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Address\StateFaker;
use Mockery;
use Tests\TestCase;

final class StateFakerTest extends TestCase
{
    protected $loader;

    protected array $states = ['Yazd', 'Tehran', 'Qom', 'Shiraz'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->states);
    }

    public function test_it_returns_fake_state(): void
    {
        $faker = new StateFaker($this->loader);
        $state = $faker->generate();

        $this->assertIsString($state);
        $this->assertContains($state, $this->states);
    }
}
