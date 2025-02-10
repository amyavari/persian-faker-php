<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Fakers\Address\PostCodeFaker;
use Tests\TestCase;

class PostCodeFakerTest extends TestCase
{
    public function test_it_returns_random_post_code_number(): void
    {
        $faker = new PostCodeFaker;
        $postCode = $this->callProtectedMethod($faker, 'generateRandomPostCode');

        $this->assertEquals(10, strlen((string) $postCode));
        $this->assertTrue($this->areDigitsInRange($postCode));
    }

    public function test_it_adds_separator_to_post_code(): void
    {
        $faker = new PostCodeFaker;
        $formattedPostCode = $this->callProtectedMethod($faker, 'addSeparator', ['1234567890']);

        $this->assertEquals('12345-67890', $formattedPostCode);
    }

    public function test_it_returns_post_code_without_separator(): void
    {
        $faker = new PostCodeFaker;
        $postCode = $faker->generate(); // Expected format: 1234567890

        $this->assertIsString($postCode);
        $this->assertEquals(10, strlen($postCode));
    }

    public function test_it_returns_post_code_with_separator(): void
    {
        $faker = new PostCodeFaker(withSeparator: true);
        $postCode = $faker->generate(); // Expected format: 12345-67890

        $this->assertIsString($postCode);
        $this->assertEquals(11, strlen($postCode));
    }

    // --------------
    // Helper methods
    // --------------

    /**
     * - Only for safety, valid digits are restricted to the range of 1-9.
     */
    protected function areDigitsInRange(string $postCode): bool
    {
        $digits = str_split($postCode);

        foreach ($digits as $digit) {
            if (! in_array((int) $digit, range(1, 9), true)) {
                return false;
            }
        }

        return true;
    }
}
