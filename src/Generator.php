<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Fakers\Person\FirstNameFaker;
use AliYavari\PersianFaker\Fakers\Person\LastNameFaker;
use AliYavari\PersianFaker\Fakers\Person\TitleFaker;
use AliYavari\PersianFaker\Loaders\DataLoaderFactory;

class Generator implements GeneratorInterface
{
    public function title(?string $gender = null): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.titles');

        return $this->exec(new TitleFaker($dataLoader, $gender));
    }

    public function titleMale(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.titles');

        return $this->exec(new TitleFaker($dataLoader, 'male'));
    }

    public function titleFemale(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.titles');

        return $this->exec(new TitleFaker($dataLoader, 'female'));
    }

    public function firstName(?string $gender = null): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.first_names');

        return $this->exec(new FirstNameFaker($dataLoader, $gender));
    }

    public function firstNameMale(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.first_names');

        return $this->exec(new FirstNameFaker($dataLoader, 'male'));
    }

    public function firstNameFemale(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.first_names');

        return $this->exec(new FirstNameFaker($dataLoader, 'female'));
    }

    public function lastName(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('person.last_names');

        return $this->exec(new LastNameFaker($dataLoader));
    }

    public function name(?string $gender = null): string
    {
        return sprintf('%s %s', $this->firstName($gender), $this->lastName());
    }

    // *******************************
    // END OF PUBLIC INTERFACE METHODS
    // *******************************

    /**
     * @template TValue
     *
     * @return \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<TValue>>
     *
     * @phpstan-ignore-next-line
     */
    protected function getDataLoaderInstance(string $dataPath): DataLoaderInterface
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<TValue>> */
        return DataLoaderFactory::getInstance($dataPath);
    }

    /**
     * @template TValue
     *
     * @param  \AliYavari\PersianFaker\Contracts\FakerInterface<TValue>  $faker
     * @return TValue
     */
    protected function exec(FakerInterface $faker)
    {
        return $faker->generate();
    }
}
