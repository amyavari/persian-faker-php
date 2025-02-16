<?php

declare(strict_types=1);

namespace Tests\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;
use AliYavari\PersianFaker\Fakers\Person\TitleFaker;
use Mockery;
use Tests\TestCase;

class TitleFakerTest extends TestCase
{
    use Arrayable;

    protected $loader;

    protected array $titles = [
        'male' => ['Mr.', 'Sr.'],
        'female' => ['Ms.', 'Mrs.', 'Miss.'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->titles);
    }

    public function test_gender_validation_passes_with_null_gender(): void
    {
        $faker = new TitleFaker($this->loader, gender: null);
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertTrue($isValid);
    }

    public function test_gender_validation_passes_with_existed_gender(): void
    {
        $gender = array_rand($this->titles);

        $faker = new TitleFaker($this->loader, gender: $gender);
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertTrue($isValid);
    }

    public function test_gender_validation_fails_with_not_existed_gender(): void
    {
        $faker = new TitleFaker($this->loader, gender: 'newGender');
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertFalse($isValid);
    }

    public function test_it_returns_all_titles_when_gender_is_not_set_or_is_null(): void
    {
        $faker = new TitleFaker($this->loader, gender: null);
        $titles = $this->callProtectedMethod($faker, 'getTitles');

        $this->assertEqualsCanonicalizing($titles, $this->flatten($this->titles));
    }

    public function test_it_returns_titles_of_specific_gender_when_gender_is_set(): void
    {
        $gender = array_rand($this->titles);

        $faker = new TitleFaker($this->loader, gender: $gender);
        $titles = $this->callProtectedMethod($faker, 'getTitles');

        $this->assertEqualsCanonicalizing($titles, $this->titles[$gender]);
    }

    public function test_it_returns_fake_title(): void
    {
        $titleFaker = new TitleFaker($this->loader);
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->flatten($this->titles));
    }

    public function test_it_returns_fake_title_for_male(): void
    {
        $titleFaker = new TitleFaker($this->loader, 'male');
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->titles['male']);
    }

    public function test_it_returns_fake_title_for_female(): void
    {
        $titleFaker = new TitleFaker($this->loader, 'female');
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->titles['female']);
    }

    public function test_it_throws_an_exception_with_invalid_gender(): void
    {
        $this->expectException(InvalidGenderException::class);
        $this->expectExceptionMessage('The gender anonymous is not valid.');

        $titleFaker = new TitleFaker($this->loader, 'anonymous');
        $titleFaker->generate();
    }
}
