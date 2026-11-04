<?php

declare(strict_types=1);

// "Without extra spaces": one space between words, and no space at the start or the end

it('contains unique titles of both genders without extra spaces', function (): void {
    $titles = fakerData('person.titles', merge: true);

    expect($titles)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueTitles = array_unique($titles);

    expect($titles)
        ->toBe($uniqueTitles);
});

it('contains unique first names of both genders without extra spaces', function (): void {
    $firstNames = fakerData('person.first_names', merge: true);

    expect($firstNames)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueFirstNames = array_unique($firstNames);

    expect($firstNames)
        ->toBe($uniqueFirstNames);
});

it('contains unique last names without extra spaces', function (): void {
    $lastNames = fakerData('person.last_names');

    expect($lastNames)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueLastNames = array_unique($lastNames);

    expect($lastNames)
        ->toBe($uniqueLastNames);
});

it('contains unique 3-digit national code prefixes of all states', function (): void {
    $nationalCodePrefixes = fakerData('person.national_code_state_prefixes', merge: true);

    expect($nationalCodePrefixes)
        ->each->toBeString()->toMatch('/^\d{3}$/');

    $uniqueNationalCodePrefixes = array_unique($nationalCodePrefixes);

    expect($nationalCodePrefixes)
        ->toBe($uniqueNationalCodePrefixes);
});

it('contains unique secondary address prefixes without extra spaces', function (): void {
    $secondaryAddressPrefixes = fakerData('address.secondary_address_prefixes');

    expect($secondaryAddressPrefixes)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueSecondaryAddressPrefixes = array_unique($secondaryAddressPrefixes);

    expect($secondaryAddressPrefixes)
        ->toBe($uniqueSecondaryAddressPrefixes);
});

it('contains unique states without extra spaces', function (): void {
    $states = fakerData('address.states');

    expect($states)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueStates = array_unique($states);

    expect($states)
        ->toBe($uniqueStates);
});

it('contains unique cities without extra spaces', function (): void {
    $cities = fakerData('address.cities');

    expect($cities)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueCities = array_unique($cities);

    expect($cities)
        ->toBe($uniqueCities);
});

it('contains unique street names without extra spaces', function (): void {
    $streetNames = fakerData('address.street_names');

    expect($streetNames)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueStreetNames = array_unique($streetNames);

    expect($streetNames)
        ->toBe($uniqueStreetNames);
});

it('contains unique addresses without extra spaces', function (): void {
    $addresses = fakerData('address.addresses');

    expect($addresses)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueAddresses = array_unique($addresses);

    expect($addresses)
        ->toBe($uniqueAddresses);
});

it('contains unique 3-digit state phone prefixes that start with 0', function (): void {
    $statePhonePrefixes = fakerData('phone.state_prefixes');

    expect($statePhonePrefixes)
        ->each->toBeString()->toMatch('/^0\d{2}$/');

    $uniqueStatePhonePrefixes = array_unique($statePhonePrefixes);

    expect($statePhonePrefixes)
        ->toBe($uniqueStatePhonePrefixes);
});

it('contains unique 4-digit mobile prefixes of all providers that start with 09', function (): void {
    $mobilePrefixes = fakerData('phone.mobile_prefixes', merge: true);

    expect($mobilePrefixes)
        ->each->toBeString()->toMatch('/^09\d{2}$/');

    $uniqueMobilePrefixes = array_unique($mobilePrefixes);

    expect($mobilePrefixes)
        ->toBe($uniqueMobilePrefixes);
});

it('contains unique company names without extra spaces', function (): void {
    $companies = fakerData('company.companies');

    expect($companies)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueCompanies = array_unique($companies);

    expect($companies)
        ->toBe($uniqueCompanies);
});

it('contains unique catchphrases without extra spaces', function (): void {
    $catchphrases = fakerData('company.catchphrases');

    expect($catchphrases)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueCatchphrases = array_unique($catchphrases);

    expect($catchphrases)
        ->toBe($uniqueCatchphrases);
});

it('contains unique job titles without extra spaces', function (): void {
    $jobTitles = fakerData('company.job_titles');

    expect($jobTitles)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueJobTitles = array_unique($jobTitles);

    expect($jobTitles)
        ->toBe($uniqueJobTitles);
});

it('contains unique words without spaces', function (): void {
    $words = fakerData('text.words');

    expect($words)
        ->each->toBeString()->toMatch('/^\S+$/u');

    $uniqueWords = array_unique($words);

    expect($words)
        ->toBe($uniqueWords);
});

it('contains unique bank names without extra spaces', function (): void {
    $bankNames = fakerData('payment.bank_names');

    expect($bankNames)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueBankNames = array_unique($bankNames);

    expect($bankNames)
        ->toBe($uniqueBankNames);
});

it('contains unique 6-digit bank BINs', function (): void {
    $bankBins = fakerData('payment.bank_bins');

    expect($bankBins)
        ->each->toBeString()->toMatch('/^\d{6}$/');

    $uniqueBankBins = array_unique($bankBins);

    expect($bankBins)
        ->toBe($uniqueBankBins);
});

it('contains unique 3-digit bank Sheba codes', function (): void {
    $bankShebaCodes = fakerData('payment.bank_sheba_codes');

    expect($bankShebaCodes)
        ->each->toBeString()->toMatch('/^\d{3}$/');

    $uniqueBankShebaCodes = array_unique($bankShebaCodes);

    expect($bankShebaCodes)
        ->toBe($uniqueBankShebaCodes);
});

it('contains unique color names of both groups without extra spaces', function (): void {
    $colors = fakerData('color.colors', merge: true);

    expect($colors)
        ->each->toBeString()->toMatch('/^\S+( \S+)*$/u');

    $uniqueColors = array_unique($colors);

    expect($colors)
        ->toBe($uniqueColors);
});
