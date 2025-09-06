<?php

declare(strict_types=1);

namespace Tests\Fakers\Phone;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Phone\StatePhonePrefixFaker;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class StatePhonePrefixFakerTest extends TestCase
{
    private $loader;

    private array $statePrefixes = ['yazd' => '035', 'teh' => '021', 'esf' => '031', 'gil' => '013'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->statePrefixes);
    }

    #[Test]
    public function it_returns_fake_state_prefix(): void
    {
        $faker = new StatePhonePrefixFaker($this->loader);
        $phonePrefix = $faker->generate();

        $this->assertIsString($phonePrefix);
        $this->assertContains($phonePrefix, $this->statePrefixes);
    }
}
