<?php

declare(strict_types=1);

namespace Tests\Fakers\Address;

use AliYavari\PersianFaker\Fakers\Address\PostCodeFaker;
use Tests\TestCase;

class PostCodeFakerTest extends TestCase
{
    public function test_it_returns_post_code_without_separator(): void
    {
        $faker = new PostCodeFaker;
        $postCode = $faker->generate();

        $this->assertIsString($postCode);
        $this->assertEquals(10, strlen($postCode));
        $this->assertTrue($this->areDigitsNumeric($postCode));
    }

    public function test_it_returns_post_code_with_separator(): void
    {
        $faker = new PostCodeFaker(withSeparator: true);
        $postCode = $faker->generate();

        $this->assertIsString($postCode);
        $this->assertEquals(11, strlen($postCode));
        $this->assertEquals(5, strpos($postCode, '-')); // Valid format: #####-#####
        $this->assertTrue($this->areDigitsNumeric($postCode));
    }

    /**
     * - Only for safety, valid digits are restricted to the range of 1-9.
     */
    protected function areDigitsNumeric(string $postCode): bool
    {
        $postCode = str_replace('-', '', $postCode);

        $digits = str_split($postCode);

        foreach ($digits as $digit) {
            if (! in_array((int) $digit, range(1, 9), true)) {
                return false;
            }
        }

        return true;
    }
}
