<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\DataLoader;
use AliYavari\PersianFaker\Generator;
use PHPUnit\Framework\TestCase;

/**
 * This includes integration tests
 */
class GeneratorTest extends TestCase
{
    use Randomable;

    protected GeneratorInterface $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new Generator;
    }

    public function test_it_returns_title(): void
    {
        $loader = new DataLoader('person.titles');
        ['male' => $maleTitles, 'female' => $femaleTitles] = $loader->get();

        $gender = $this->getOneRandomElement([null, 'male', 'female']);

        $title = $this->generator->title($gender);

        $this->assertIsString($title);
        $this->assertContains($title, array_merge($maleTitles, $femaleTitles));
    }

    public function test_it_returns_male_title(): void
    {
        $loader = new DataLoader('person.titles');
        ['male' => $maleTitles, 'female' => $femaleTitles] = $loader->get();

        $title = $this->generator->titleMale();

        $this->assertIsString($title);
        $this->assertContains($title, $maleTitles);
    }

    public function test_it_returns_female_title(): void
    {
        $loader = new DataLoader('person.titles');
        ['male' => $maleTitles, 'female' => $femaleTitles] = $loader->get();

        $title = $this->generator->titleFemale();

        $this->assertIsString($title);
        $this->assertContains($title, $femaleTitles);
    }

    public function test_it_returns_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        ['male' => $maleNames, 'female' => $femaleNames] = $loader->get();

        $gender = $this->getOneRandomElement([null, 'male', 'female']);

        $firstName = $this->generator->firstName($gender);

        $this->assertIsString($firstName);
        $this->assertContains($firstName, array_merge($maleNames, $femaleNames));
    }

    public function test_it_returns_male_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        ['male' => $maleNames, 'female' => $femaleNames] = $loader->get();

        $firstName = $this->generator->firstNameMale();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $maleNames);
    }

    public function test_it_returns_female_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        ['male' => $maleNames, 'female' => $femaleNames] = $loader->get();

        $firstName = $this->generator->firstNameFemale();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $femaleNames);
    }

    public function test_it_returns_last_name(): void
    {
        $loader = new DataLoader('person.last_names');
        $lastNames = $loader->get();

        $lastName = $this->generator->lastName();

        $this->assertIsString($lastName);
        $this->assertContains($lastName, $lastNames);
    }

    public function test_it_returns_full_name(): void
    {
        $gender = $this->getOneRandomElement([null, 'male', 'female']);

        $name = $this->generator->name($gender);

        $this->assertIsString($name);
        $this->assertIsArray(explode(' ', $name));
    }

    public function test_it_returns_national_code(): void
    {
        $loader = new DataLoader('person.national_code_state_prefixes');
        $statePrefixes = $loader->get();

        $state = array_rand($statePrefixes);

        $nationalCode = $this->generator->nationalCode($state);

        $this->assertIsString($nationalCode);
        $this->assertContains(substr($nationalCode, 0, 3), $statePrefixes[$state]);
    }

    public function test_it_returns_secondary_address(): void
    {
        $loader = new DataLoader('address.secondary_address_prefixes');
        $secondaryAddressPrefixes = $loader->get();

        $secondaryAddress = $this->generator->secondaryAddress();

        [$prefix, $number] = explode(' ', $secondaryAddress);

        $this->assertIsString($secondaryAddress);
        $this->assertContains($prefix, $secondaryAddressPrefixes);
        $this->assertIsNumeric($number);
    }

    public function test_it_returns_state(): void
    {
        $loader = new DataLoader('address.states');
        $states = $loader->get();

        $state = $this->generator->state();

        $this->assertIsString($state);
        $this->assertContains($state, $states);
    }

    public function test_it_returns_city(): void
    {
        $loader = new DataLoader('address.cities');
        $cities = $loader->get();

        $city = $this->generator->city();

        $this->assertIsString($city);
        $this->assertContains($city, $cities);
    }

    public function test_it_returns_street_name(): void
    {
        $loader = new DataLoader('address.street_names');
        $streetNames = $loader->get();

        $streetName = $this->generator->streetName();

        $this->assertIsString($streetName);
        $this->assertContains($streetName, $streetNames);
    }

    public function test_it_returns_address(): void
    {
        $loader = new DataLoader('address.addresses');
        $addresses = $loader->get();

        $address = $this->generator->address();

        $this->assertIsString($address);
        $this->assertContains($address, $addresses);
    }

    public function test_it_returns_post_code(): void
    {
        $withSeparator = $this->getOneRandomElement([true, false]);

        $postCode = $this->generator->postCode($withSeparator);

        $this->assertIsString($postCode);

        if ($withSeparator) {
            $this->assertSame(11, strlen($postCode));
        } else {
            $this->assertSame(10, strlen($postCode));
        }
    }

    public function test_it_returns_state_phone_prefix(): void
    {
        $loader = new DataLoader('phone.state_prefixes');
        $statePrefixes = $loader->get();

        $statePrefix = $this->generator->statePhonePrefix();

        $this->assertIsString($statePrefix);
        $this->assertContains($statePrefix, $statePrefixes);
    }

    public function test_it_returns_phone_number(): void
    {
        $loader = new DataLoader('phone.state_prefixes');
        $statePrefixes = $loader->get();

        $separator = $this->getOneRandomElement([' ', '-']);
        $state = array_rand($statePrefixes);

        $phoneNumber = $this->generator->phoneNumber($separator, $state);

        $this->assertIsString($phoneNumber);
        $this->assertSame($statePrefixes[$state], substr($phoneNumber, 0, 3));
        $this->assertSame(3, strpos($phoneNumber, (string) $separator));
    }

    public function test_it_returns_cell_phone_number(): void
    {
        $loader = new DataLoader('phone.mobile_prefixes');
        $mobilePrefixes = $loader->get();

        $separator = $this->getOneRandomElement([' ', '-']);
        $mobileProvider = array_rand($mobilePrefixes);

        $cellPhoneNumber = $this->generator->cellPhone($separator, $mobileProvider);

        $this->assertIsString($cellPhoneNumber);
        $this->assertContains(substr($cellPhoneNumber, 0, 4), $mobilePrefixes[$mobileProvider]);
        $this->assertSame(4, strpos($cellPhoneNumber, (string) $separator));
    }

    public function test_it_returns_company_name(): void
    {
        $loader = new DataLoader('company.companies');
        $companies = $loader->get();

        $company = $this->generator->company();

        $this->assertIsString($company);
        $this->assertContains($company, $companies);
    }

    public function test_it_returns_company_catchphrase(): void
    {
        $loader = new DataLoader('company.catchphrases');
        $catchphrases = $loader->get();

        $catchphrase = $this->generator->catchphrase();

        $this->assertIsString($catchphrase);
        $this->assertContains($catchphrase, $catchphrases);
    }

    public function test_it_returns_job_title(): void
    {
        $loader = new DataLoader('company.job_titles');
        $jobTitles = $loader->get();

        $jobTitle = $this->generator->jobTitle();

        $this->assertIsString($jobTitle);
        $this->assertContains($jobTitle, $jobTitles);
    }

    public function test_it_returns_word(): void
    {
        $loader = new DataLoader('text.words');
        $words = $loader->get();

        $word = $this->generator->word();

        $this->assertIsString($word);
        $this->assertContains($word, $words);
    }

    public function test_it_returns_words_as_array(): void
    {

        $words = $this->generator->words(4, false);

        $this->assertIsArray($words);
        $this->assertCount(4, $words);
    }

    public function test_it_returns_words_as_string(): void
    {
        $words = $this->generator->words(4, true);

        $this->assertIsString($words);
        $this->assertCount(4, explode(' ', $words));
    }

    public function test_it_returns_sentence_with_strict_number_of_words(): void
    {

        $sentence = $this->generator->sentence(50, false);

        $this->assertIsString($sentence);
        $this->assertCount(50, explode(' ', $sentence));
    }

    public function test_it_returns_sentence_with_variable_number_of_words(): void
    {
        $runs = 10;
        $wordNumbers = [];

        for ($i = 1; $i <= $runs; $i++) {
            $sentence = $this->generator->sentence(50, true);

            $this->assertIsString($sentence);

            $wordNumbers[] = count(explode(' ', $sentence));
        }

        $this->assertGreaterThan(1, count(array_unique($wordNumbers)));
    }

    public function test_it_returns_sentences_as_array(): void
    {
        $sentences = $this->generator->sentences(4, false);

        $this->assertIsArray($sentences);
        $this->assertCount(4, $sentences);
    }

    public function test_it_returns_sentences_as_string(): void
    {
        $sentences = $this->generator->sentences(4, true);

        $this->assertIsString($sentences);
        $this->assertCount(4, explode('. ', $sentences));
    }

    public function test_it_returns_paragraph_with_strict_number_of_sentences(): void
    {
        $paragraph = $this->generator->paragraph(50, false);

        $this->assertIsString($paragraph);
        $this->assertCount(50, explode('. ', $paragraph));
    }

    public function test_it_returns_paragraph_with_variable_number_of_sentences(): void
    {
        $runs = 10;
        $sentenceNumbers = [];

        for ($i = 1; $i <= $runs; $i++) {
            $paragraph = $this->generator->paragraph(50, true);

            $this->assertIsString($paragraph);

            $sentenceNumbers[] = count(explode('. ', $paragraph));
        }

        $this->assertGreaterThan(1, count(array_unique($sentenceNumbers)));
    }

    public function test_it_returns_paragraphs_as_array(): void
    {
        $paragraphs = $this->generator->paragraphs(4, false);

        $this->assertIsArray($paragraphs);
        $this->assertCount(4, $paragraphs);
    }

    public function test_it_returns_paragraphs_as_string(): void
    {
        $paragraphs = $this->generator->paragraphs(4, true);

        $this->assertIsString($paragraphs);
        $this->assertCount(4, explode("\n", $paragraphs));
    }

    public function test_it_returns_text(): void
    {
        $text = $this->generator->text(300);

        $this->assertIsString($text);
        $this->assertLessThanOrEqual(300, mb_strlen($text));
    }

    public function test_it_returns_bank_name(): void
    {
        $loader = new DataLoader('payment.bank_names');
        $banks = $loader->get();

        $bank = $this->generator->bank();

        $this->assertIsString($bank);
        $this->assertContains($bank, $banks);
    }

    public function test_it_returns_fake_bank_card_number(): void
    {
        $loader = new DataLoader('payment.bank_bins');
        $bankBins = $loader->get();

        $separator = $this->getOneRandomElement([' ', '-']);
        $bank = array_rand($bankBins);

        $cardNumber = $this->generator->cardNumber(separator: $separator, bank: $bank);

        $this->assertIsString($cardNumber);
        $this->assertSame(19, strlen($cardNumber));

        $cardNumberDigits = str_replace($separator, '', $cardNumber);
        $this->assertSame($bankBins[$bank], substr($cardNumberDigits, 0, 6));
        $this->assertSame(16, strlen($cardNumberDigits));
    }

    public function test_it_returns_fake_bank_sheba_number(): void
    {
        $loader = new DataLoader('payment.bank_sheba_codes');
        $bankCodes = $loader->get();

        $separator = $this->getOneRandomElement([' ', '-']);
        $bank = array_rand($bankCodes);

        $shebaNumber = $this->generator->shebaNumber(withIR: false, separator: $separator, bank: $bank);

        $this->assertIsString($shebaNumber);
        $this->assertSame(30, strlen($shebaNumber));

        $shebaNumberDigits = str_replace($separator, '', $shebaNumber);
        $this->assertSame($bankCodes[$bank], substr($shebaNumberDigits, 2, 3));
        $this->assertSame(24, strlen($shebaNumberDigits));
    }

    public function test_it_returns_safe_color_name(): void
    {
        $loader = new DataLoader('color.colors');
        $colors = $loader->get();

        $color = $this->generator->safeColorName();

        $this->assertIsString($color);
        $this->assertContains($color, $colors['main']);
    }

    public function test_it_returns_color_name(): void
    {
        $loader = new DataLoader('color.colors');
        $colors = $loader->get();

        $color = $this->generator->colorName();

        $this->assertIsString($color);
        $this->assertContains($color, array_merge($colors['main'], $colors['all']));
    }
}
