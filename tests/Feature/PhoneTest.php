<?php

declare(strict_types=1);

use AliYavari\PersianFaker\Exceptions\InvalidMobileProviderException;
use AliYavari\PersianFaker\Exceptions\InvalidStateNameException;

// The mobile provider names in the docs: docs/en/04-phone.md (cellPhone)
dataset('providers', [
    'mci' => ['provider' => 'mci'],
    'mtn' => ['provider' => 'mtn'],
    'rightel' => ['provider' => 'rightel'],
    'shatel' => ['provider' => 'shatel'],
]);

it('returns a state phone prefix from the data file', function (): void {
    expect(persian_faker()->statePhonePrefix())
        ->toBeIn(fakerData('phone.state_prefixes'));
});

it('returns a phone number of any state', function (): void {
    $phoneNumber = persian_faker()->phoneNumber();

    expect($phoneNumber)
        ->toBeDigits()
        ->toHaveLength(11);

    expect(mb_substr($phoneNumber, 0, 3)) // The first three digits are the state prefix
        ->toBeIn(fakerData('phone.state_prefixes'));
});

it('returns a phone number of the given state', function (string $state): void {
    expect(persian_faker()->phoneNumber(state: $state))
        ->toBeDigits()
        ->toHaveLength(11)
        ->toStartWith(fakerValue("phone.state_prefixes.{$state}"));
})->with('states');

it('returns a phone number with the given separator', function (): void {
    expect(persian_faker()->phoneNumber(separator: '-'))
        ->toMatch('/^\d{3}-\d{8}$/');
});

it('throws an exception for a phone number with an invalid state', function (): void {
    expect(fn (): string => persian_faker()->phoneNumber(state: 'anonymous'))
        ->toThrow(InvalidStateNameException::class, 'The state name anonymous is not valid.');
});

it('returns a cell phone number of any provider', function (): void {
    $cellPhoneNumber = persian_faker()->cellPhone();

    expect($cellPhoneNumber)
        ->toBeDigits()
        ->toHaveLength(11);

    expect(mb_substr($cellPhoneNumber, 0, 4)) // The first four digits are the provider prefix
        ->toBeIn(fakerData('phone.mobile_prefixes', merge: true));
});

it('returns a cell phone number of the given provider', function (string $provider): void {
    $cellPhoneNumber = persian_faker()->cellPhone(provider: $provider);

    expect($cellPhoneNumber)
        ->toBeDigits()
        ->toHaveLength(11);

    expect(mb_substr($cellPhoneNumber, 0, 4)) // The first four digits are the provider prefix
        ->toBeIn(fakerData("phone.mobile_prefixes.{$provider}"));
})->with('providers');

it('returns a cell phone number with the given separator', function (): void {
    expect(persian_faker()->cellPhone(separator: '-'))
        ->toMatch('/^\d{4}-\d{3}-\d{4}$/');
});

it('throws an exception for a cell phone number with an invalid provider', function (): void {
    expect(fn (): string => persian_faker()->cellPhone(provider: 'anonymous'))
        ->toThrow(InvalidMobileProviderException::class, 'The mobile provider with name anonymous is not valid.');
});
