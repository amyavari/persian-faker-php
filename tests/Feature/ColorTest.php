<?php

declare(strict_types=1);

it('returns a safe color name from the main colors', function (): void {
    expect(persian_faker()->safeColorName())
        ->toBeIn(fakerData('color.colors.main'));
});

it('returns a color name from all colors', function (): void {
    expect(persian_faker()->colorName())
        ->toBeIn(fakerData('color.colors', merge: true)); // The main colors and the other colors
});
