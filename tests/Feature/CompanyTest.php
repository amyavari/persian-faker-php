<?php

declare(strict_types=1);

it('returns a company name from the data file', function (): void {
    expect(persian_faker()->company())
        ->toBeIn(fakerData('company.companies'));
});

it('returns a catchphrase from the data file', function (): void {
    expect(persian_faker()->catchphrase())
        ->toBeIn(fakerData('company.catchphrases'));
});

it('returns a job title from the data file', function (): void {
    expect(persian_faker()->jobTitle())
        ->toBeIn(fakerData('company.job_titles'));
});
