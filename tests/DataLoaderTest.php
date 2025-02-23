<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\DataLoader;
use AliYavari\PersianFaker\Exceptions\FileNotFoundException;
use AliYavari\PersianFaker\Exceptions\InvalidDataKeyException;
use AliYavari\PersianFaker\Exceptions\InvalidDataPathException;
use TypeError;

class DataLoaderTest extends TestCase
{
    public function test_it_returns_array_value_with_one_dimensional_key(): void
    {
        $array = [
            'key' => 123,
        ];
        $keys = ['key'];

        $loader = new DataLoader('');
        $value = $this->callProtectedMethod($loader, 'getArrayDataByNestedKeys', [$array, $keys]);

        $this->assertSame(123, $value);
    }

    public function test_it_returns_array_value_with_multi_dimensional_key(): void
    {
        $array = [
            'first_key' => [
                'second_key' => [
                    'third_key' => ['one', 'two', 'three'],
                ],
            ],
        ];
        $keys = ['first_key', 'second_key', 'third_key'];

        $loader = new DataLoader('');
        $value = $this->callProtectedMethod($loader, 'getArrayDataByNestedKeys', [$array, $keys]);

        $this->assertSame(['one', 'two', 'three'], $value);
    }

    public function test_it_throws_an_exception_with_invalid_array_key(): void
    {
        $array = [
            'first_key' => 'single_value',
        ];

        $keys = ['wrong_key'];

        $this->expectException(InvalidDataKeyException::class);
        $this->expectExceptionMessage('The key wrong_key is not a valid key inside the file.');

        $loader = new DataLoader('');
        $this->callProtectedMethod($loader, 'getArrayDataByNestedKeys', [$array, $keys]);
    }

    public function test_it_throws_an_exception_with_invalid_array_structure(): void
    {
        $array = [
            'first_key' => 'single_value',
        ];

        $keys = ['first_key', 'second_key'];

        $this->expectException(TypeError::class);
        $this->expectExceptionMessage(DataLoader::class.'::getArrayDataByNestedKeys(): Argument #1 ($array) must be of type array, string given');

        $loader = new DataLoader('');
        $this->callProtectedMethod($loader, 'getArrayDataByNestedKeys', [$array, $keys]);
    }

    public function test_it_loads_file_inside_data_directory(): void
    {
        // This test needs corresponded test.php file in ./src/data directory
        $fileName = 'test';

        $loader = new DataLoader('');
        $fileContent = $this->callProtectedMethod($loader, 'loadFile', [$fileName]);

        $this->assertIsArray($fileContent);
    }

    public function test_it_throws_an_exception_with_invalid_file_name(): void
    {
        $fileName = 'wrongFile';
        $expectedFilePath = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'wrongFile.php';

        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage(sprintf('The file %s is not found.', $expectedFilePath));

        $loader = new DataLoader('');
        $this->callProtectedMethod($loader, 'loadFile', [$fileName]);
    }

    public function test_it_separates_file_name_and_keys_from_path(): void
    {
        $path = 'fileName.first_key.second_key';

        $loader = new DataLoader($path);
        $fileNameAndKeys = $this->callProtectedMethod($loader, 'getFileNameAndKeys');

        $this->assertEquals([
            'file_name' => 'fileName',
            'keys' => ['first_key', 'second_key'],
        ], $fileNameAndKeys);
    }

    public function test_it_throws_an_exception_with_invalid_file_and_keys_path(): void
    {
        $path = 'test-key';

        $this->expectException(InvalidDataPathException::class);
        $this->expectExceptionMessage('The path test-key is not correct path for file name and array key separated with dot(.).');

        $loader = new DataLoader($path);
        $this->callProtectedMethod($loader, 'getFileNameAndKeys');
    }

    public function test_it_returns_data_from_correct_file_name_and_keys(): void
    {
        // This test needs corresponded test.php file in ./src/data directory
        $path = 'test.first_key.second_key';

        $loader = new DataLoader($path);
        $content = $loader->get();

        $this->assertEquals([
            'key' => 'value',
        ], $content);
    }
}
