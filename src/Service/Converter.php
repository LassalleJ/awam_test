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

    public function convert(array $dataFields): array|false
    {
//      Récupération des données du formulaire
        $currencyOne = $dataFields['currency_one'];
        $currencyTwo = $dataFields['currency_two'];

        $valueOne = $dataFields['value_one'];
        $valueTwo = $dataFields['value_two'];

        $currencyResult = $dataFields['currency_result'];


//      Si le taux de change n'existe pas, renvoi d'un booléen false
        if(!$this->exchangeRateRepository->findRate($currencyOne->getId(), $currencyResult->getId()) || !$this->exchangeRateRepository->findRate($currencyTwo->getId(), $currencyResult->getId())) {
            return false;
        }

//      Si le taux existe, calcul des conversions et modification de l'array obtenue du formulaire avec les nouvelles valeurs
        $dataFields['value_one'] = $currencyOne === $currencyResult ? $valueOne : $valueOne * $this->exchangeRateRepository->findRate($currencyOne->getId(), $currencyResult->getId());
        $dataFields['value_two'] = $currencyTwo === $currencyResult ? $valueTwo : $valueTwo * $this->exchangeRateRepository->findRate($currencyTwo->getId(), $currencyResult->getId());

//      Renvoi de l'array avec les nouvelles valeurs
        return $dataFields;
    }

}