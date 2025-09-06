<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Factory;

if (! function_exists('persian_faker') && class_exists(Factory::class)) {
    /**
     * Get a persian faker instance.
     */
    function persian_faker(): GeneratorInterface
    {
        if (! class_exists('Illuminate\Foundation\Application') && ! function_exists('app')) {
            return Factory::create();
        }

        $abstract = 'persianFaker';

        if (! app()->bound($abstract)) { // @phpstan-ignore function.notFound
            app()->singleton($abstract, fn () => Factory::create()); // @phpstan-ignore function.notFound
        }

        return app()->make($abstract); // @phpstan-ignore function.notFound
    }
}
