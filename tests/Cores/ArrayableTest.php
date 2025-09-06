<?php

declare(strict_types=1);

namespace Tests\Cores;

use AliYavari\PersianFaker\Cores\Arrayable;
use AliYavari\PersianFaker\Exceptions\InvalidMultiDimensionalArray;
use AliYavari\PersianFaker\Exceptions\InvalidStringArrayException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Tests\TestCase;

final class ArrayableTest extends TestCase
{
    use Arrayable;

    // ---------------
    // Data Providers
    // ---------------

    /**
     * Provides datasets in the format: `dataset => [mixed $element, string $type]`
     */
    public static function invalidToStringElementProvider(): iterable
    {
        yield 'bool' => [true, 'bool'];

        yield 'int' => [23, 'int'];

        yield 'float' => [2.3, 'float'];

        yield 'object' => [new stdClass, 'stdClass'];

        yield 'array' => [['arr'], 'array'];
    }

    #[Test]
    public function it_flattens_a_single_level_of_an_array(): void
    {
        $arr = [
            'level_one_string' => ['array_one', 'array_two'],
            'level_one_others' => [true, false, 123],
            'level_one_nested_array' => ['nested_key' => 'value'],
        ];

        $expected = ['array_one', 'array_two', true, false, 123, 'nested_key' => 'value'];

        $this->assertSame($expected, $this->flatten($arr));
    }

    #[Test]
    public function flatten_throws_an_exception_if_input_is_not_one_dimensional_array(): void
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

    #[Test]
    public function it_turns_an_array_of_string_to_one_string(): void
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

    #[Test]
    public function it_turns_an_array_of_string_to_one_string_with_custom_separator(): void
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

    #[Test]
    #[DataProvider('invalidToStringElementProvider')]
    public function to_string_throws_an_exception_if_elements_of_input_array_are_not_string(mixed $element, string $type): void
    {
        $arr = [
            'first text',
            'second',
            $element,
        ];

        $this->expectException(InvalidStringArrayException::class);
        $this->expectExceptionMessage("The givin array should only contains string, {$type} is given at key 2");

        $this->convertToString($arr);
    }
}
