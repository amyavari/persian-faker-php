<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use Mockery;
use Tests\TestCase;

class LastNameFakerTest extends TestCase
{
    protected $loader;

    protected array $lastNames = ['name one', 'name two', 'name three', 'name four'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->lastNames);
    }

    public function test_it_returns_fake_last_name(): void
    {
        $faker = new LastNameFaker($this->loader);
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->lastNames);
    }
}
