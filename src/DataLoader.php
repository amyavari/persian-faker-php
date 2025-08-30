<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\FileNotFoundException;
use AliYavari\PersianFaker\Exceptions\InvalidDataKeyException;
use AliYavari\PersianFaker\Exceptions\InvalidDataPathException;

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
    public function __construct(
        protected string $path
    ) {}

    /**
     * This loads data from the path and retrieves it
     *
     * @return array<TKey, TData>
     */
    public function get()
    {
        ['file_name' => $fileName, 'keys' => $keys] = $this->getFileNameAndKeys();

        $array = $this->loadFile($fileName);

        /** @var array<TKey, TData> */
        return $this->getArrayDataByNestedKeys($array, $keys);
    }

    /**
     * @return array{file_name: string, keys: list<string>}
     *
     * @throws InvalidDataPathException
     */
    private function getFileNameAndKeys(): array
    {
        $fileKeys = explode('.', $this->path);

        if (count($fileKeys) < 2) {
            throw new InvalidDataPathException(
                sprintf('The path %s is not correct path for file name and array key separated with dot(.).', $this->path)
            );
        }

        return [
            'file_name' => array_shift($fileKeys),
            'keys' => $fileKeys,
        ];
    }

    /**
     * @return array<string, mixed>
     *
     * @throws FileNotFoundException
     */
    private function loadFile(string $fileName)
    {
        $filePath = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$fileName.'.php';

        if (! file_exists($filePath)) {
            throw new FileNotFoundException(sprintf('The file %s is not found.', $filePath));
        }

        return require $filePath;
    }

    /**
     * TODO fix generic types for this method.
     *
     * @throws FileNotFoundException
     *
     * @phpstan-ignore-next-line
     */
    private function getArrayDataByNestedKeys(array $array, array $keys)
    {
        $currentKey = (string) array_shift($keys);

        if (! array_key_exists($currentKey, $array)) {
            throw new InvalidDataKeyException(sprintf('The key %s is not a valid key inside the file.', $currentKey));
        }

        $content = $array[$currentKey];

        if ($keys === []) {
            return $content;
        }

        return $this->getArrayDataByNestedKeys($content, $keys);
    }
}
