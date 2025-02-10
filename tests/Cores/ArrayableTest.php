<?php

declare(strict_types=1);

namespace Tests\Cores;

use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidMultiDimensionalArray;
use Tests\TestCase;

class ArrayableTest extends TestCase
{
    use Arrayable;

    public function test_it_flattens_a_single_level_of_an_array(): void
    {
        $arr = [
            'level_one_string' => ['array_one', 'array_two'],
            'level_one_others' => [true, false, 123],
            'level_one_nested_array' => ['nested_key' => 'value'],
        ];

        $expected = ['array_one', 'array_two', true, false, 123, 'nested_key' => 'value'];

        $this->assertEquals($expected, $this->flatten($arr));
    }

    public function test_it_throws_an_exception_if_is_one_dimensional_array(): void
    {
        $arr = [
            'invalid_element' => 'single_value',
            'level_one_others' => [true, false, 123],
            'level_one_nested_array' => ['nested_key' => 'value'],
        ];

        $this->expectException(InvalidMultiDimensionalArray::class);
        $this->expectExceptionMessage('The key invalid_element does not refer to an array.');

        $this->flatten($arr);
    }
}
