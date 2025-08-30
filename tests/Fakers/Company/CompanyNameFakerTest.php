<?php

declare(strict_types=1);

namespace Tests\Fakers\Company;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\Company\CompanyNameFaker;
use Mockery;
use Tests\TestCase;

final class CompanyNameFakerTest extends TestCase
{
    protected $loader;

    protected array $names = ['company one', 'company two', 'company three'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->names);
    }

    public function test_it_returns_fake_company_name(): void
    {
        $faker = new CompanyNameFaker($this->loader);
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->names);
    }
}
