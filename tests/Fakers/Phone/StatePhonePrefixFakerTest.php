<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Fakers\Phone\StatePhonePrefixFaker;
use AliYavari\PersianFaker\Loaders\DataLoader;
use Mockery;
use Tests\TestCase;

class StatePhonePrefixFakerTest extends TestCase
{
    protected $loader;

    protected array $statePrefixes = ['yazd' => '035', 'teh' => '021', 'esf' => '031', 'gil' => '013'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoader::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->statePrefixes);
    }

    public function test_it_returns_fake_state_prefix(): void
    {
        $faker = new StatePhonePrefixFaker($this->loader);
        $phonePrefix = $faker->generate();

        $this->assertIsString($phonePrefix);
        $this->assertContains($phonePrefix, $this->statePrefixes);
    }
}
