<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;

/**
 * @internal
 *
 * This class loads data from a path and retrieves it
 *
 * @property string $path Follows the format: "filename.key_one.key_two.key_three...",
 *                        where "filename" refers to the data file, and the subsequent keys
 *                        specify the nested values to retrieve separated by dot(.).
 *
 * @template TKey of array-key
 * @template TData
 *
 * @implements DataLoaderInterface<TKey, TData>
 */
final class DataLoader implements DataLoaderInterface
{
    /**
     * The data files that are already loaded, by file name. Each file is loaded only once.
     *
     * @var array<string, array<string, mixed>>
     */
    private static array $loadedFiles = [];

    public function __construct(
        private readonly string $path
    ) {}

    /**
     * This loads data from the path and retrieves it
     *
     * @return array<TKey, TData>
     */
    public function get(): array
    {
        ['file_name' => $fileName, 'keys' => $keys] = $this->getFileNameAndKeys();

        $array = $this->loadFile($fileName);

        return $this->getArrayDataByNestedKeys($array, $keys);
    }

    /**
     * @return array{file_name: string, keys: list<string>}
     */
    private function getFileNameAndKeys(): array
    {
        $fileKeys = explode('.', $this->path);

        return [
            'file_name' => array_shift($fileKeys),
            'keys' => $fileKeys,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function loadFile(string $fileName): array
    {
        if (array_key_exists($fileName, self::$loadedFiles)) {
            return self::$loadedFiles[$fileName];
        }

        $filePath = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$fileName.'.php';

        self::$loadedFiles[$fileName] = require $filePath;

        return self::$loadedFiles[$fileName];
    }

    /**
     * @param  array<mixed>  $array
     * @param  list<string>  $keys
     */
    private function getArrayDataByNestedKeys(array $array, array $keys): mixed
    {
        $currentKey = array_shift($keys);

        $content = $array[$currentKey];

        if ($keys === []) {
            return $content;
        }

        return $this->getArrayDataByNestedKeys($content, $keys);
    }
}
