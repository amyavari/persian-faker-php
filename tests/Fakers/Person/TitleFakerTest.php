<?php

declare(strict_types=1);

namespace Tests\Fakers\Person;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidGenderException;
use AliYavari\PersianFaker\Fakers\Person\TitleFaker;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class TitleFakerTest extends TestCase
{
    use Arrayable;

    private $loader;

    private array $titles = [
        'male' => ['Mr.', 'Sr.'],
        'female' => ['Ms.', 'Mrs.', 'Miss.'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->loader = Mockery::mock(DataLoaderInterface::class);
        $this->loader->shouldReceive('get')->once()->andReturn($this->titles);
    }

    #[Test]
    public function gender_validation_passes_with_null_gender(): void
    {
        $faker = new TitleFaker($this->loader, gender: null);
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    public function gender_validation_passes_with_existed_gender(): void
    {
        $faker = new TitleFaker($this->loader, gender: 'male');
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertTrue($isValid);
    }

    #[Test]
    public function gender_validation_fails_with_not_existed_gender(): void
    {
        $faker = new TitleFaker($this->loader, gender: 'newGender');
        $isValid = $this->callProtectedMethod($faker, 'isGenderValid');

        $this->assertFalse($isValid);
    }

    #[Test]
    public function it_returns_all_titles_when_gender_is_not_set_or_is_null(): void
    {
        $faker = new TitleFaker($this->loader, gender: null);
        $titles = $this->callProtectedMethod($faker, 'getTitles');

        $this->assertEqualsCanonicalizing($this->flatten($this->titles), $titles); // All titles
    }

    #[Test]
    public function it_returns_titles_of_specific_gender_when_gender_is_set(): void
    {
        $faker = new TitleFaker($this->loader, gender: 'female');
        $titles = $this->callProtectedMethod($faker, 'getTitles');

        $this->assertEqualsCanonicalizing($this->titles['female'], $titles);
    }

    #[Test]
    public function it_returns_fake_title(): void
    {
        $titleFaker = new TitleFaker($this->loader);
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->flatten($this->titles)); // All titles
    }

    #[Test]
    public function it_returns_fake_title_with_gender_is_set(): void
    {
        $titleFaker = new TitleFaker($this->loader, gender: 'male');
        $title = $titleFaker->generate();

        $this->assertIsString($title);
        $this->assertContains($title, $this->titles['male']);
    }

    #[Test]
    public function it_throws_an_exception_with_invalid_gender(): void
    {
        $this->expectException(InvalidGenderException::class);
        $this->expectExceptionMessage('The gender anonymous is not valid.');

        $titleFaker = new TitleFaker($this->loader, 'anonymous');
        $titleFaker->generate();
    }
}
