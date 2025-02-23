<?php

declare(strict_types=1);

namespace Tests\Cores;

use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidElementNumberException;
use PHPUnit\Framework\TestCase;

class RandomableTest extends TestCase
{
    use Randomable;

    public function test_it_returns_one_random_item(): void
    {
        $data = ['item_one', 'item_two', 'item_three'];

        $randomItem = $this->getOneRandomElement($data);

        $this->assertIsString($randomItem);
        $this->assertContains($randomItem, $data);
    }

    public function test_it_returns_multiple_random_items(): void
    {
        $data = ['item_one', 'item_two', 'item_three', 'item_four', 'item_five'];

        $randomItems = $this->getMultipleRandomElements($data, 3);

        $this->assertIsArray($randomItems);
        $this->assertCount(3, $randomItems);
    }

    public function test_it_throws_an_exception_if_number_of_returned_elements_is_less_that_1(): void
    {
        $data = ['item_one', 'item_two', 'item_three', 'item_four', 'item_five'];

        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of returned elements must be 1 or more, 0 is given.');

        $this->getMultipleRandomElements($data, 0);

        $this->expectException(InvalidElementNumberException::class);
        $this->expectExceptionMessage('The number of returned elements must be 1 or more, -1 is given.');

        $this->getMultipleRandomElements($data, -1);
    }
}
