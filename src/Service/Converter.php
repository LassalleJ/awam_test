<?php

namespace App\Service;

use App\Repository\ExchangeRateRepository;

class Converter
{
    public function __construct(
        private ExchangeRateRepository $exchangeRateRepository
    )
    {

    }

    public function convert(array $dataFields): array
    {
        $currencyOne = $dataFields['currency_one'];
        $currencyTwo = $dataFields['currency_two'];

        $valueOne = $dataFields['value_one'];
        $valueTwo = $dataFields['value_two'];

        $currencyResult = $dataFields['currency_result'];

        $dataFields['value_one'] = $currencyOne === $currencyResult ? $valueOne : $valueOne * $this->exchangeRateRepository->findRate($currencyOne->getId(), $currencyResult->getId());
        $dataFields['value_two'] = $currencyTwo === $currencyResult ? $valueTwo : $valueTwo * $this->exchangeRateRepository->findRate($currencyTwo->getId(), $currencyResult->getId());

        return $dataFields;
    }

}