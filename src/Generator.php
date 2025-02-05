<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Fakers\TitleFaker;
use AliYavari\PersianFaker\Loaders\DataLoaderFactory;

class Generator implements GeneratorInterface
{
    public function title(?string $gender = null): string
    {
        /** @var DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.titles');

        return $this->exec(new TitleFaker($dataLoader, $gender));
    }

    public function titleMale(): string
    {
        /** @var DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.titles');

        return $this->exec(new TitleFaker($dataLoader, 'male'));
    }

    public function titleFemale(): string
    {
        /** @var DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.titles');

        return $this->exec(new TitleFaker($dataLoader, 'female'));
    }

    /**
     * @template TValue
     *
     * @return DataLoaderInterface<string, list<TValue>>
     *
     * @phpstan-ignore-next-line
     */
    protected function getDataLoaderInstance(string $dataPath): DataLoaderInterface
    {
        /** @var DataLoaderInterface<string, list<TValue>> */
        return DataLoaderFactory::getInstance($dataPath);
    }

    /**
     * @template TValue
     *
     * @param  FakerInterface<TValue>  $faker
     * @return TValue
     */
    protected function exec(FakerInterface $faker)
    {
        return $faker->generate();
    }
}
