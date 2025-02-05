<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Exceptions\FileNotFoundException;
use AliYavari\PersianFaker\Exceptions\InvalidDataKeyException;
use AliYavari\PersianFaker\Exceptions\InvalidDataPathException;

/**
 * Loads data from a file and retrieves values based on a dot-separated key path.
 *
 * @property string $path Follows the format: "filename.key_one.key_two.key_three...",
 *                        where "filename" refers to the data file, and the subsequent keys
 *                        specify the nested values to retrieve.
 *
 * @template TValue
 *
 * @implements DataLoaderInterface<array<sting, TValue>>
 */
class DataLoader implements DataLoaderInterface
{
    public function __construct(
        protected string $path
    ) {}

    /**
     * Retrieves the data associated with the specified path.
     *
     * @return array<string, TValue>|TValue
     */
    public function get()
    {
        ['file_name' => $fileName, 'keys' => $keys] = $this->getFileNameAndKeys();

        $array = $this->loadFile($fileName);

        return $this->getArrayDataByNestedKeys($array, $keys);
    }

    /**
     * @return array{file_name: string, keys: list<string>}
     */
    protected function getFileNameAndKeys(): array
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
     * @return array<string, TValue>
     */
    protected function loadFile(string $fileName)
    {
        $filePath = __DIR__."/Data/$fileName.php";

        if (! file_exists($filePath)) {
            throw new FileNotFoundException(sprintf('The file %s is not found.', $filePath));
        }

        return require $filePath;
    }

    /**
     * @param  array<string, TValue>  $array
     * @param  list<string>  $keys
     * @return array<string, TValue>|TValue
     */
    protected function getArrayDataByNestedKeys(array $array, array $keys)
    {
        $currentKey = (string) array_shift($keys);

        if (! array_key_exists($currentKey, $array)) {
            throw new InvalidDataKeyException(sprintf('The key %s is not a valid key inside the file.', $currentKey));
        }

        $content = $array[$currentKey];

        if ($keys === []) {
            return $content;
        }

        /**@phpstan-ignore-next-line */
        return $this->getArrayDataByNestedKeys($content, $keys);
    }
}
