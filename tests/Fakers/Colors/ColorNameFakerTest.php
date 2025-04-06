<?php

declare(strict_types=1);

namespace Tests\Fakers\Payment;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidDataKeyException;
use AliYavari\PersianFaker\Fakers\Colors\ColorNameFaker;
use Mockery;
use Tests\TestCase;

class ColorNameFakerTest extends TestCase
{
    use Arrayable;

    protected $loader;

    protected array $colors = [
        'main' => ['color1', 'color2', 'color3', 'color4'],
        'all' => ['color5', 'color6', 'color7', 'color8'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->colors)->byDefault();
    }

    public function test_validation_passes_with_existence_of_necessary_keys(): void
    {
        $faker = new ColorNameFaker($this->loader);
        $hasKeys = $this->callProtectedMethod($faker, 'hasNecessaryKeys', [['main' => [], 'all' => []]]);

        $this->assertTrue($hasKeys);
    }

    public function test_validation_fails_with_missing_of_necessary_keys(): void
    {
        $faker = new ColorNameFaker($this->loader);
        $hasKeys = $this->callProtectedMethod($faker, 'hasNecessaryKeys', [['main' => []]]);

        $this->assertFalse($hasKeys);

        $hasKeys = $this->callProtectedMethod($faker, 'hasNecessaryKeys', [['all' => []]]);

        $this->assertFalse($hasKeys);
    }

    public function test_it_returns_only_main_colors_when_only_main_is_set_to_true(): void
    {
        $faker = new ColorNameFaker($this->loader, onlyMain: true);
        $colors = $this->callProtectedMethod($faker, 'getColors');

        $this->assertIsArray($colors);
        $this->assertEqualsCanonicalizing($this->colors['main'], $colors);
    }

    public function test_it_returns_all_colors_when_only_main_is_set_to_false(): void
    {
        $faker = new ColorNameFaker($this->loader);
        $colors = $this->callProtectedMethod($faker, 'getColors');

        $this->assertIsArray($colors);
        $this->assertEqualsCanonicalizing($this->flatten($this->colors), $colors); // `main` and `all` colors
    }

    public function test_it_returns_fake_color_name(): void
    {
        $faker = new ColorNameFaker($this->loader);
        $color = $faker->generate();

        $this->assertIsString($color);
        $this->assertContains($color, $this->flatten($this->colors)); // `main` and `all` colors
    }

    public function test_it_returns_fake_main_color_name(): void
    {
        $faker = new ColorNameFaker($this->loader, onlyMain: true);
        $color = $faker->generate();

        $this->assertIsString($color);
        $this->assertContains($color, $this->colors['main']);
    }

    public function test_it_throws_an_exception_if_necessary_keys_are_not_present(): void
    {
        $this->loader->shouldReceive('get')->once()->andReturn(['another_key' => []]);

        $this->expectException(InvalidDataKeyException::class);
        $this->expectExceptionMessage('The colors array must have "main" and "all" keys.');

        new ColorNameFaker($this->loader);
    }
}
