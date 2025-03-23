<?php

declare(strict_types=1);

namespace Tests\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;
use AliYavari\PersianFaker\Fakers\Person\FirstNameFaker;
use Mockery;
use Tests\TestCase;

class FirstNameFakerTest extends TestCase
{
    use Arrayable;

    protected $loader;

    protected array $names = [
        'male' => ['male one', 'male two', 'male three'],
        'female' => ['female one', 'female two', 'female three'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->names);
    }

    public function test_gender_validation_passes_with_null_gender(): void
    {
        $faker = new FirstNameFaker($this->loader, gender: null);
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertTrue($isValid);
    }

    public function test_gender_validation_passes_with_existed_gender(): void
    {
        $gender = array_rand($this->names);

        $faker = new FirstNameFaker($this->loader, gender: $gender);
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertTrue($isValid);
    }

    public function test_gender_validation_fails_with_not_existed_gender(): void
    {
        $faker = new FirstNameFaker($this->loader, gender: 'newGender');
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_all_names_when_gender_is_not_set_or_is_null(): void
    {
        $faker = new FirstNameFaker($this->loader, gender: null);
        $names = $this->callProtectedMethod($faker, 'getNames');

        $this->assertEqualsCanonicalizing($this->flatten($this->names), $names);
    }

    public function test_it_returns_names_of_specific_gender_when_gender_is_set(): void
    {
        $gender = array_rand($this->names);

        $faker = new FirstNameFaker($this->loader, gender: $gender);
        $names = $this->callProtectedMethod($faker, 'getNames');

        $this->assertEqualsCanonicalizing($this->names[$gender], $names);
    }

    public function test_it_returns_fake_first_name(): void
    {
        $faker = new FirstNameFaker($this->loader);
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->flatten($this->names));
    }

    public function test_it_returns_fake_male_first_name(): void
    {

        $faker = new FirstNameFaker($this->loader, 'male');
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->names['male']);

    }

    public function test_it_returns_fake_female_first_name(): void
    {

        $faker = new FirstNameFaker($this->loader, 'female');
        $name = $faker->generate();

        $this->assertIsString($name);
        $this->assertContains($name, $this->names['female']);
    }

    public function test_it_throws_an_exception_with_invalid_gender(): void
    {
        $this->expectException(InvalidGenderException::class);
        $this->expectExceptionMessage('The gender anonymous is not valid.');

        $faker = new FirstNameFaker($this->loader, 'anonymous');
        $faker->generate();
    }
}
