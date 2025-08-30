<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\DataLoader;
use AliYavari\PersianFaker\Generator;

/**
 * This includes integration tests
 */
final class GeneratorTest extends TestCase
{
    use Arrayable;

    private GeneratorInterface $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new Generator;
    }

    public function test_it_returns_title(): void
    {
        $loader = new DataLoader('person.titles');
        $titles = $loader->get(); // ['male' => [...], 'female' => [...]]

        // Default (random gender)
        $title = $this->generator->title();

        $this->assertIsString($title);
        $this->assertContains($title, $this->flatten($titles));

        // For specific gender
        $title = $this->generator->title('male');

        $this->assertIsString($title);
        $this->assertContains($title, $titles['male']);
    }

    public function test_it_returns_male_title(): void
    {
        $loader = new DataLoader('person.titles');
        $titles = $loader->get(); // ['male' => [...], 'female' => [...]]

        $title = $this->generator->titleMale();

        $this->assertIsString($title);
        $this->assertContains($title, $titles['male']);
    }

    public function test_it_returns_female_title(): void
    {
        $loader = new DataLoader('person.titles');
        $titles = $loader->get(); // ['male' => [...], 'female' => [...]]

        $title = $this->generator->titleFemale();

        $this->assertIsString($title);
        $this->assertContains($title, $titles['female']);
    }

    public function test_it_returns_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        $names = $loader->get(); // ['male' => [...], 'female' => [...]]

        // Default (random gender)
        $firstName = $this->generator->firstName();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $this->flatten($names));

        // For specific gender
        $firstName = $this->generator->firstName('male');

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $names['male']);
    }

    public function test_it_returns_male_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        $names = $loader->get(); // ['male' => [...], 'female' => [...]]

        $firstName = $this->generator->firstNameMale();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $names['male']);
    }

    public function test_it_returns_female_first_name(): void
    {
        $loader = new DataLoader('person.first_names');
        $names = $loader->get(); // ['male' => [...], 'female' => [...]]

        $firstName = $this->generator->firstNameFemale();

        $this->assertIsString($firstName);
        $this->assertContains($firstName, $names['female']);
    }

    public function test_it_returns_last_name(): void
    {
        $loader = new DataLoader('person.last_names');
        $lastNames = $loader->get(); // [...]

        $lastName = $this->generator->lastName();

        $this->assertIsString($lastName);
        $this->assertContains($lastName, $lastNames);
    }

    public function test_it_returns_full_name(): void
    {
        // Default (random gender)
        $name = $this->generator->name();

        $this->assertIsString($name);
        $this->assertIsArray(explode(' ', $name));

        // For specific gender
        $name = $this->generator->name('male');

        $this->assertIsString($name);
        $this->assertIsArray(explode(' ', $name));
    }

    public function test_it_returns_national_code(): void
    {
        $loader = new DataLoader('person.national_code_state_prefixes');
        $statePrefixes = $loader->get(); // ['STATE_NAME' => [...]]

        // Default (random state)
        $nationalCode = $this->generator->nationalCode();

        $this->assertIsString($nationalCode);
        $this->assertContains(mb_substr($nationalCode, 0, 3), $this->flatten($statePrefixes));

        // For specific state
        $nationalCode = $this->generator->nationalCode('yazd');

        $this->assertIsString($nationalCode);
        $this->assertContains(mb_substr($nationalCode, 0, 3), $statePrefixes['yazd']);
    }

    public function test_it_returns_secondary_address(): void
    {
        $loader = new DataLoader('address.secondary_address_prefixes');
        $secondaryAddressPrefixes = $loader->get(); // [...]

        $secondaryAddress = $this->generator->secondaryAddress();

        [$prefix, $number] = explode(' ', $secondaryAddress);

        $this->assertIsString($secondaryAddress);
        $this->assertContains($prefix, $secondaryAddressPrefixes);
        $this->assertIsNumeric($number);
    }

    public function test_it_returns_state(): void
    {
        $loader = new DataLoader('address.states');
        $states = $loader->get(); // [...]

        $state = $this->generator->state();

        $this->assertIsString($state);
        $this->assertContains($state, $states);
    }

    public function test_it_returns_city(): void
    {
        $loader = new DataLoader('address.cities');
        $cities = $loader->get(); // [...]

        $city = $this->generator->city();

        $this->assertIsString($city);
        $this->assertContains($city, $cities);
    }

    public function test_it_returns_street_name(): void
    {
        $loader = new DataLoader('address.street_names');
        $streetNames = $loader->get(); // [...]

        $streetName = $this->generator->streetName();

        $this->assertIsString($streetName);
        $this->assertContains($streetName, $streetNames);
    }

    public function test_it_returns_address(): void
    {
        $loader = new DataLoader('address.addresses');
        $addresses = $loader->get(); // [...]

        $address = $this->generator->address();

        $this->assertIsString($address);
        $this->assertContains($address, $addresses);
    }

    public function test_it_returns_post_code(): void
    {
        // Default (without separator)
        $postCode = $this->generator->postCode();

        $this->assertIsString($postCode);
        $this->assertSame(10, mb_strlen($postCode));

        // With separator
        $postCode = $this->generator->postCode(true);

        $this->assertIsString($postCode);
        $this->assertSame(11, mb_strlen($postCode));
    }

    public function test_it_returns_state_phone_prefix(): void
    {
        $loader = new DataLoader('phone.state_prefixes');
        $statePrefixes = $loader->get(); // ['STATE_NAME' => 'PREFIX']

        $statePrefix = $this->generator->statePhonePrefix();

        $this->assertIsString($statePrefix);
        $this->assertContains($statePrefix, $statePrefixes);
    }

    public function test_it_returns_phone_number(): void
    {
        $loader = new DataLoader('phone.state_prefixes');
        $statePrefixes = $loader->get(); // ['STATE_NAME' => 'PREFIX']

        // Default (without separator, random state)
        $phoneNumber = $this->generator->phoneNumber();

        $this->assertIsString($phoneNumber);
        $this->assertContains(mb_substr($phoneNumber, 0, 3), $statePrefixes);
        $this->assertSame(11, mb_strlen($phoneNumber));

        // With separator, for specific state
        $phoneNumber = $this->generator->phoneNumber('-', 'yazd');

        $this->assertIsString($phoneNumber);
        $this->assertSame($statePrefixes['yazd'], mb_substr($phoneNumber, 0, 3));
        $this->assertSame(12, mb_strlen($phoneNumber));
        $this->assertSame(11, mb_strlen(str_replace('-', '', $phoneNumber)));
    }

    public function test_it_returns_cell_phone_number(): void
    {
        $loader = new DataLoader('phone.mobile_prefixes');
        $mobilePrefixes = $loader->get(); // ['PROVIDER' => [...]]

        // Default (without separator, random provider)
        $cellPhoneNumber = $this->generator->cellPhone();

        $this->assertIsString($cellPhoneNumber);
        $this->assertContains(mb_substr($cellPhoneNumber, 0, 4), $this->flatten($mobilePrefixes));
        $this->assertSame(11, mb_strlen($cellPhoneNumber));

        // With separator, for specific state
        $cellPhoneNumber = $this->generator->cellPhone('-', 'mtn');

        $this->assertIsString($cellPhoneNumber);
        $this->assertContains(mb_substr($cellPhoneNumber, 0, 4), $mobilePrefixes['mtn']);
        $this->assertSame(13, mb_strlen($cellPhoneNumber));
        $this->assertSame(11, mb_strlen(str_replace('-', '', $cellPhoneNumber)));
    }

    public function test_it_returns_company_name(): void
    {
        $loader = new DataLoader('company.companies');
        $companies = $loader->get(); // [...]

        $company = $this->generator->company();

        $this->assertIsString($company);
        $this->assertContains($company, $companies);
    }

    public function test_it_returns_company_catchphrase(): void
    {
        $loader = new DataLoader('company.catchphrases');
        $catchphrases = $loader->get(); // [...]

        $catchphrase = $this->generator->catchphrase();

        $this->assertIsString($catchphrase);
        $this->assertContains($catchphrase, $catchphrases);
    }

    public function test_it_returns_job_title(): void
    {
        $loader = new DataLoader('company.job_titles');
        $jobTitles = $loader->get(); // [...]

        $jobTitle = $this->generator->jobTitle();

        $this->assertIsString($jobTitle);
        $this->assertContains($jobTitle, $jobTitles);
    }

    public function test_it_returns_word(): void
    {
        $loader = new DataLoader('text.words');
        $words = $loader->get(); // [...]

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
        $banks = $loader->get(); // [...]

        $bank = $this->generator->bank();

        $this->assertIsString($bank);
        $this->assertContains($bank, $banks);
    }

    public function test_it_returns_fake_bank_card_number(): void
    {
        $loader = new DataLoader('payment.bank_bins');
        $bankBins = $loader->get(); // ['BANK_NAME' => 'BIN']

        // Default (without separator, random bank)
        $cardNumber = $this->generator->cardNumber();

        $this->assertIsString($cardNumber);
        $this->assertSame(16, mb_strlen($cardNumber));
        $this->assertContains(mb_substr($cardNumber, 0, 6), $bankBins);

        // With separator, for specific bank
        $cardNumber = $this->generator->cardNumber('-', 'mellat');

        $this->assertIsString($cardNumber);
        $this->assertSame(19, mb_strlen($cardNumber));

        $rawCardNumber = str_replace('-', '', $cardNumber);
        $this->assertSame(16, mb_strlen($rawCardNumber));
        $this->assertSame($bankBins['mellat'], mb_substr($rawCardNumber, 0, 6));
    }

    public function test_it_returns_fake_bank_sheba_number(): void
    {
        $loader = new DataLoader('payment.bank_sheba_codes');
        $bankCodes = $loader->get(); // ['BANK_NAME' => 'CODE']

        // Default (with IR, without separator, random bank)
        $shebaNumber = $this->generator->shebaNumber();

        $this->assertIsString($shebaNumber);
        $this->assertSame(26, mb_strlen($shebaNumber));
        $this->assertSame('IR', mb_substr($shebaNumber, 0, 2));
        $this->assertContains(mb_substr($shebaNumber, 4, 3), $bankCodes);

        // Without IR, with separator, for specific bank
        $shebaNumber = $this->generator->shebaNumber(false, '-', 'mellat');

        $this->assertIsString($shebaNumber);
        $this->assertSame(30, mb_strlen($shebaNumber));
        $this->assertNotEquals('IR', mb_substr($shebaNumber, 0, 2));

        $rawShebaNumber = str_replace('-', '', $shebaNumber);
        $this->assertSame(24, mb_strlen($rawShebaNumber));
        $this->assertSame($bankCodes['mellat'], mb_substr($rawShebaNumber, 2, 3));
    }

    public function test_it_returns_safe_color_name(): void
    {
        $loader = new DataLoader('color.colors');
        $colors = $loader->get(); // ['main' => [...], 'all' => [...]]

        $color = $this->generator->safeColorName();

        $this->assertIsString($color);
        $this->assertContains($color, $colors['main']);
    }

    public function test_it_returns_color_name(): void
    {
        $loader = new DataLoader('color.colors');
        $colors = $loader->get(); // ['main' => [...], 'all' => [...]]

        $color = $this->generator->colorName();

        $this->assertIsString($color);
        $this->assertContains($color, $this->flatten($colors));
    }
}
