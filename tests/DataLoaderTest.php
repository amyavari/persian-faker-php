<?php

declare(strict_types=1);

namespace Tests;

use AliYavari\PersianFaker\DataLoader;
use AliYavari\PersianFaker\Exceptions\FileNotFoundException;
use AliYavari\PersianFaker\Exceptions\InvalidDataKeyException;
use AliYavari\PersianFaker\Exceptions\InvalidDataPathException;
use PHPUnit\Framework\Attributes\Test;
use TypeError;

final class DataLoaderTest extends TestCase
{
    private string $dataDirectoryPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataDirectoryPath = dirname(__DIR__, 1).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    }

    #[Test]
    public function it_returns_array_value_with_one_dimensional_key(): void
    {
        $array = [
            'key' => 123,
        ];
        $keys = ['key'];

        $loader = new DataLoader('');
        $value = $this->callProtectedMethod($loader, 'getArrayDataByNestedKeys', [$array, $keys]);

        $this->assertSame(123, $value);
    }

    #[Test]
    public function it_returns_array_value_with_multi_dimensional_key(): void
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

    #[Test]
    public function it_throws_an_exception_with_invalid_array_key(): void
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

    #[Test]
    public function it_throws_an_exception_with_invalid_array_structure(): void
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

    #[Test]
    public function it_loads_file_inside_data_directory(): void
    {
        file_put_contents($this->dataDirectoryPath.'test.php', '<?php return [];');

        $loader = new DataLoader('');
        $fileContent = $this->callProtectedMethod($loader, 'loadFile', ['test']);

        $this->assertIsArray($fileContent);

        unlink($this->dataDirectoryPath.'test.php');
    }

    #[Test]
    public function it_throws_an_exception_with_invalid_file_name(): void
    {
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage(sprintf('The file %s is not found.', $this->dataDirectoryPath.'wrongFile.php'));

        $loader = new DataLoader('');
        $this->callProtectedMethod($loader, 'loadFile', ['wrongFile']);
    }

    #[Test]
    public function it_separates_file_name_and_keys_from_path(): void
    {
        $loader = new DataLoader(path: 'fileName.first_key.second_key');
        $fileNameAndKeys = $this->callProtectedMethod($loader, 'getFileNameAndKeys');

        $this->assertSame([
            'file_name' => 'fileName',
            'keys' => ['first_key', 'second_key'],
        ], $fileNameAndKeys);
    }

    #[Test]
    public function it_throws_an_exception_with_invalid_file_and_keys_path(): void
    {
        $path = 'test-key';

        $this->expectException(InvalidDataPathException::class);
        $this->expectExceptionMessage('The path test-key is not correct path for file name and array key separated with dot(.).');

        $loader = new DataLoader($path);
        $this->callProtectedMethod($loader, 'getFileNameAndKeys');
    }

    #[Test]
    public function it_returns_data_from_correct_file_name_and_keys(): void
    {
        $fileContent = '
        <?php
        return [
            "first_key" => [
                "second_key" => [
                    "key" => "value",
                ],
            ],
        ];
        ';

        file_put_contents($this->dataDirectoryPath.'test.php', $fileContent);

        $loader = new DataLoader(path: 'test.first_key.second_key');
        $content = $loader->get();

        $this->assertSame([
            'key' => 'value',
        ], $content);

        unlink($this->dataDirectoryPath.'test.php');
    }
}
