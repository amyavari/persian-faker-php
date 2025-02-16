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

    public function test_it_returns_secondary_address(): void
    {
        $loader = new DataLoader('address.secondary_address_prefixes');
        $secondaryAddressPrefixes = $loader->get();

        $secondaryAddress = $this->generator->secondaryAddress();

        [$prefix,$number] = explode(' ', $secondaryAddress);

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
            $this->assertEquals(11, strlen($postCode));
        } else {
            $this->assertEquals(10, strlen($postCode));

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
        $this->assertEquals(substr($phoneNumber, 0, 3), $statePrefixes[$state]);
        $this->assertEquals(3, strpos($phoneNumber, (string) $separator));
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
        $this->assertEquals(4, strpos($cellPhoneNumber, (string) $separator));
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

    public function test_it_returns_words(): void
    {
        $asText = $this->getOneRandomElement([true, false]);

        $words = $this->generator->words(4, $asText);

        if ($asText) {
            $this->assertIsString($words);
            $this->assertEquals(4, count(explode(' ', $words)));
        } else {
            $this->assertIsArray($words);
            $this->assertEquals(4, count($words));
        }
    }

    public function test_it_returns_sentence(): void
    {
        $variableNbWords = $this->getOneRandomElement([true, false]);

        $sentence = $this->generator->sentence(50, $variableNbWords);

        $this->assertIsString($sentence);

        if ($variableNbWords) {
            $this->assertNotEquals(50, count(explode(' ', $sentence)));
        } else {
            $this->assertEquals(50, count(explode(' ', $sentence)));
        }
    }

    public function test_it_returns_sentences(): void
    {
        $asText = $this->getOneRandomElement([true, false]);

        $sentences = $this->generator->sentences(4, $asText);

        if ($asText) {
            $this->assertIsString($sentences);
            $this->assertEquals(4, count(explode('. ', $sentences)));
        } else {
            $this->assertIsArray($sentences);
            $this->assertEquals(4, count($sentences));
        }
    }

    public function test_it_returns_paragraph(): void
    {
        $variableNbSentences = $this->getOneRandomElement([true, false]);

        $paragraph = $this->generator->paragraph(50, $variableNbSentences);

        $this->assertIsString($paragraph);

        if ($variableNbSentences) {
            $this->assertNotEquals(50, count(explode('. ', $paragraph)));
        } else {
            $this->assertEquals(50, count(explode('. ', $paragraph)));
        }
    }

    public function test_it_returns_paragraphs(): void
    {
        $asText = $this->getOneRandomElement([true, false]);

        $paragraphs = $this->generator->paragraphs(4, $asText);

        if ($asText) {
            $this->assertIsString($paragraphs);
            $this->assertEquals(4, count(explode("\n", $paragraphs)));
        } else {
            $this->assertIsArray($paragraphs);
            $this->assertEquals(4, count($paragraphs));
        }
    }

    public function test_it_returns_text(): void
    {
        $text = $this->generator->text(300);

        $this->assertIsString($text);
        $this->assertLessThanOrEqual(300, strlen($text));
    }
}
