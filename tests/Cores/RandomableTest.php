<?php

declare(strict_types=1);

namespace Tests\Cores;

use AliYavari\PersianFaker\Cores\Randomable;
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
        $this->assertEquals(3, count($randomItems));
    }
}
