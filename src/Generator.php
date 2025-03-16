<?php

declare(strict_types=1);

namespace AliYavari\PersianFaker;

use AliYavari\PersianFaker\Contracts\DataLoaderInterface;
use AliYavari\PersianFaker\Contracts\FakerInterface;
use AliYavari\PersianFaker\Contracts\GeneratorInterface;
use AliYavari\PersianFaker\Fakers\Address\AddressFaker;
use AliYavari\PersianFaker\Fakers\Address\CityFaker;
use AliYavari\PersianFaker\Fakers\Address\PostCodeFaker;
use AliYavari\PersianFaker\Fakers\Address\SecondaryAddressFaker;
use AliYavari\PersianFaker\Fakers\Address\StateFaker;
use AliYavari\PersianFaker\Fakers\Address\StreetNameFaker;
use AliYavari\PersianFaker\Fakers\Company\CatchphraseFaker;
use AliYavari\PersianFaker\Fakers\Company\CompanyNameFaker;
use AliYavari\PersianFaker\Fakers\Company\JobTitleFaker;
use AliYavari\PersianFaker\Fakers\Payment\BankNameFaker;
use AliYavari\PersianFaker\Fakers\Payment\CardNumberFaker;
use AliYavari\PersianFaker\Fakers\Person\FirstNameFaker;
use AliYavari\PersianFaker\Fakers\Person\LastNameFaker;
use AliYavari\PersianFaker\Fakers\Person\NationalCodeFaker;
use AliYavari\PersianFaker\Fakers\Person\TitleFaker;
use AliYavari\PersianFaker\Fakers\Phone\CellPhoneFaker;
use AliYavari\PersianFaker\Fakers\Phone\PhoneNumberFaker;
use AliYavari\PersianFaker\Fakers\Phone\StatePhonePrefixFaker;
use AliYavari\PersianFaker\Fakers\Text\ParagraphFaker;
use AliYavari\PersianFaker\Fakers\Text\SentenceFaker;
use AliYavari\PersianFaker\Fakers\Text\TextFaker;
use AliYavari\PersianFaker\Fakers\Text\WordFaker;

/**
 * This class includes all final faker methods of this package.
 *
 * These methods are designed to generate fake data for various purposes,
 * such as testing and development. Each method is responsible for producing
 * a specific type of fake data.
 */
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

    public function nationalCode(?string $state = null): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('person.national_code_state_prefixes');

        return $this->exec(new NationalCodeFaker($dataLoader, $state));
    }

    public function secondaryAddress(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('address.secondary_address_prefixes');

        return $this->exec(new SecondaryAddressFaker($dataLoader));
    }

    public function state(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('address.states');

        return $this->exec(new StateFaker($dataLoader));
    }

    public function city(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('address.cities');

        return $this->exec(new CityFaker($dataLoader));
    }

    public function streetName(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('address.street_names');

        return $this->exec(new StreetNameFaker($dataLoader));
    }

    public function address(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('address.addresses');

        return $this->exec(new AddressFaker($dataLoader));
    }

    public function postCode(bool $withSeparator = false): string
    {
        return $this->exec(new PostCodeFaker($withSeparator));
    }

    public function statePhonePrefix(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, string> */
        $dataLoader = $this->getDataLoaderInstance('phone.state_prefixes');

        return $this->exec(new StatePhonePrefixFaker($dataLoader));
    }

    public function phoneNumber(string $separator = '', ?string $state = null): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, string> */
        $dataLoader = $this->getDataLoaderInstance('phone.state_prefixes');

        return $this->exec(new PhoneNumberFaker($dataLoader, $separator, $state));
    }

    public function cellPhone(string $separator = '', ?string $provider = null): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, list<string>> */
        $dataLoader = $this->getDataLoaderInstance('phone.mobile_prefixes');

        return $this->exec(new CellPhoneFaker($dataLoader, $separator, $provider));
    }

    public function company(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('company.companies');

        return $this->exec(new CompanyNameFaker($dataLoader));
    }

    public function catchphrase(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('company.catchphrases');

        return $this->exec(new CatchphraseFaker($dataLoader));
    }

    public function jobTitle(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('company.job_titles');

        return $this->exec(new JobTitleFaker($dataLoader));
    }

    public function word(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        /** @var string */
        return $this->exec(new WordFaker($dataLoader, nbWords: 1, asText: true));
    }

    public function words(int $nb = 3, bool $asText = false): string|array
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        return $this->exec(new WordFaker($dataLoader, $nb, $asText));
    }

    public function sentence(int $nbWords = 6, bool $variableNbWords = true): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        $wordFaker = new WordFaker($dataLoader);

        /** @var string */
        return $this->exec(new SentenceFaker($wordFaker, nbWords: $nbWords, nbSentences: 1, asText: true, variableNbWords: $variableNbWords));
    }

    public function sentences(int $nb = 3, bool $asText = false): string|array
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        $wordFaker = new WordFaker($dataLoader);

        return $this->exec(new SentenceFaker($wordFaker, nbWords: 6, nbSentences: $nb, asText: $asText, variableNbWords: true));
    }

    public function paragraph(int $nbSentences = 3, bool $variableNbSentences = true): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        $sentenceFaker = new SentenceFaker(new WordFaker($dataLoader));

        /** @var string */
        return $this->exec(new ParagraphFaker($sentenceFaker, nbSentences: $nbSentences, nbParagraphs: 1, asText: true, variableNbSentences: $variableNbSentences));
    }

    public function paragraphs(int $nb = 3, bool $asText = false): string|array
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        $sentenceFaker = new SentenceFaker(new WordFaker($dataLoader));

        return $this->exec(new ParagraphFaker($sentenceFaker, nbSentences: 3, nbParagraphs: $nb, asText: $asText, variableNbSentences: true));
    }

    public function text(int $maxNbChars = 200): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('text.words');

        return $this->exec(new TextFaker($dataLoader, maxNbChars: $maxNbChars));
    }

    public function bank(): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<int, string> */
        $dataLoader = $this->getDataLoaderInstance('payment.bank_names');

        return $this->exec(new BankNameFaker($dataLoader));
    }

    public function cardNumber(string $separator = '', ?string $bank = null): string
    {
        /** @var \AliYavari\PersianFaker\Contracts\DataLoaderInterface<string, string> */
        $dataLoader = $this->getDataLoaderInstance('payment.bank_bins');

        return $this->exec(new CardNumberFaker($dataLoader, separator: $separator, bank: $bank));
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
        /** @var \AliYavari\PersianFaker\DataLoader<string, list<TValue>> */
        return new DataLoader($dataPath);
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
