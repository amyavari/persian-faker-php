<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Factory;

it('creates a generator with the factory', function (): void {
    expect(Factory::create())
        ->toBeInstanceOf(GeneratorInterface::class);
});

it('returns a generator from the persian_faker() helper', function (): void {
    expect(persian_faker())
        ->toBeInstanceOf(GeneratorInterface::class);
});

it('returns a generator from the persian_faker() helper in a non-Laravel project with its own app() function', function (): void {
    require_once __DIR__.'/../Fixtures/app.php';

    expect(persian_faker())
        ->toBeInstanceOf(GeneratorInterface::class);
});
