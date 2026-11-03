<?php

declare(strict_types=1);

arch()->preset()->security()->ignoring('array_rand');
arch()->preset()->php();

arch("Pest's classes are not imported in the src")
    ->expect('AliYavari\PersianFaker')
    ->not->toUse('Pest\Support');
