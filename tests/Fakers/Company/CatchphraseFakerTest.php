<?php

declare(strict_types=1);

namespace Tests\Fakers\Company;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Company\CatchphraseFaker;
use Mockery;
use Tests\TestCase;

class CatchPhraseFakerTest extends TestCase
{
    protected $loader;

    protected array $catchphrases = ['first phrase', 'second wonderful phrase', 'third catchphrase for test'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->catchphrases);
    }

    public function test_it_returns_fake_catchphrase(): void
    {
        $faker = new CatchphraseFaker($this->loader);
        $catchphrase = $faker->generate();

        $this->assertIsString($catchphrase);
        $this->assertContains($catchphrase, $this->catchphrases);
    }
}
