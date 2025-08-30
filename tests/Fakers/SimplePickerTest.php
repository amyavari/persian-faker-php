<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Fakers\SimplePicker;
use Mockery;
use Tests\TestCase;

final class SimplePickerTest extends TestCase
{
    private $loader;

    private array $simpleArray = ['element 1', 'element 4', 'element 3', 'element 2'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->simpleArray);
    }

    public function test_it_returns_random_element_from_loaded_data(): void
    {
        $faker = new class($this->loader) extends SimplePicker {};
        $element = $this->callProtectedMethod($faker, 'generate');

        $this->assertContains($element, $this->simpleArray);
    }
}
