<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Generator;
use AliYavari\PersianFaker\Loaders\DataLoader;
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
}
