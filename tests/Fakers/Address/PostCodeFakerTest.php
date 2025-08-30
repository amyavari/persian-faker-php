<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Fakers\Address\PostCodeFaker;
use Tests\TestCase;

final class PostCodeFakerTest extends TestCase
{
    public function test_it_returns_random_post_code_number(): void
    {
        $faker = new PostCodeFaker;
        $postCode = $this->callProtectedMethod($faker, 'generateRandomPostCode');

        $this->assertIsString($postCode);
        $this->assertSame(10, mb_strlen($postCode));
        $this->assertMatchesRegularExpression('/^[1-9]{10}$/', $postCode);
    }

    public function test_it_adds_separator_to_post_code(): void
    {
        $faker = new PostCodeFaker;
        $formattedPostCode = $this->callProtectedMethod($faker, 'addSeparator', ['1234567890']);

        $this->assertSame('12345-67890', $formattedPostCode);
    }

    public function test_it_returns_post_code_without_separator(): void
    {
        $faker = new PostCodeFaker;
        $postCode = $faker->generate(); // Expected format: 1234567890

        $this->assertIsString($postCode);
        $this->assertSame(10, mb_strlen($postCode));
        $this->assertMatchesRegularExpression('/^[1-9]{10}$/', $postCode);
    }

    public function test_it_returns_post_code_with_separator(): void
    {
        $faker = new PostCodeFaker(withSeparator: true);
        $postCode = $faker->generate(); // Expected format: 12345-67890

        $this->assertIsString($postCode);
        $this->assertSame(11, mb_strlen($postCode));
        $this->assertMatchesRegularExpression('/^[1-9]{5}\-[1-9]{5}$/', $postCode);
    }
}
