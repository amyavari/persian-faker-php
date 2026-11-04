<?php

declare(strict_types=1);

it('returns a secondary address with a prefix and a number from 1 to 50', function (): void {
    $secondaryAddress = persian_faker()->secondaryAddress();

    expect($secondaryAddress)
        ->toMatch('/^\S+ \d+$/u'); // A prefix, a space and a number

    [$prefix, $number] = explode(' ', $secondaryAddress);

    expect($prefix)
        ->toBeIn(fakerData('address.secondary_address_prefixes'));

    expect((int) $number)
        ->toBeBetween(1, 50);
});

it('returns a state from the data file', function (): void {
    expect(persian_faker()->state())
        ->toBeIn(fakerData('address.states'));
});

it('returns a city from the data file', function (): void {
    expect(persian_faker()->city())
        ->toBeIn(fakerData('address.cities'));
});

it('returns a street name from the data file', function (): void {
    expect(persian_faker()->streetName())
        ->toBeIn(fakerData('address.street_names'));
});

it('returns an address from the data file', function (): void {
    expect(persian_faker()->address())
        ->toBeIn(fakerData('address.addresses'));
});

it('returns a post code of 10 digits', function (): void {
    expect(persian_faker()->postCode())
        ->toMatch('/^[1-9]{10}$/'); // Each digit is from 1 to 9
});

it('returns a post code with a separator', function (): void {
    expect(persian_faker()->postCode(withSeparator: true))
        ->toMatch('/^[1-9]{5}-[1-9]{5}$/');
});
