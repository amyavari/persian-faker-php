<?php

declare(strict_types=1);

namespace Tests\Cores;

use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Cores\Randomable;
use AliYavari\PersianFaker\Exceptions\InvalidMultiDimensionalArray;
use AliYavari\PersianFaker\Exceptions\InvalidStringArrayException;
use stdClass;
use Tests\TestCase;

class ArrayableTest extends TestCase
{
    use Arrayable, Randomable;

    public function test_it_flattens_a_single_level_of_an_array(): void
    {
        $arr = [
            'level_one_string' => ['array_one', 'array_two'],
            'level_one_others' => [true, false, 123],
            'level_one_nested_array' => ['nested_key' => 'value'],
        ];

        $expected = ['array_one', 'array_two', true, false, 123, 'nested_key' => 'value'];

        $this->assertSame($expected, $this->flatten($arr));
    }

    public function test_flatten_throws_an_exception_if_input_is_not_one_dimensional_array(): void
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

    public function test_it_turns_an_array_of_string_to_one_string(): void
    {
        $arr = [
            'first text',
            'second',
            'With Number 2',
        ];

        $output = $this->convertToString($arr);

        $this->assertIsString($output);
        $this->assertSame('first text second With Number 2', $output);
    }

    public function test_it_turns_an_array_of_string_to_one_string_with_custom_separator(): void
    {
        $arr = [
            'first text',
            'second',
            'With Number 2',
        ];

        $output = $this->convertToString($arr, '-');

        $this->assertIsString($output);
        $this->assertSame('first text-second-With Number 2', $output);
    }

    public function test_to_string_throws_an_exception_if_elements_of_input_array_are_not_string(): void
    {
        $invalidElement = $this->getOneRandomElement([true, false, 23, 26.4, new stdClass, ['array']]);
        $arr = [
            'first text',
            'second',
            $invalidElement,
        ];

        $this->expectException(InvalidStringArrayException::class);
        $this->expectExceptionMessage('The givin array should only contains string, '.get_debug_type($invalidElement).' is given at key 2');

        $this->convertToString($arr);
    }
}
