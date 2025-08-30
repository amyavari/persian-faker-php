<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\Test;

final class HelpersTest extends TestCase
{
    #[Test]
    public function persian_faker_helper_returns_generator_instance_and_works(): void
    {
        $faker = persian_faker();
        $this->assertInstanceOf(\AliYavari\PersianFaker\Generator::class, $faker);

        $name = $faker->name();
        $this->assertIsString($name);
        $this->assertNotEmpty($name);
    }
}
