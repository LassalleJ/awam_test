<?php

namespace App\DataFixtures;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExchangeRateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $exchangeRate = new ExchangeRate();

        $exchangeRate->setCurrencyFrom($this->getReference('dollar'));
        $exchangeRate->setCurrencyTo($this->getReference('euro'));
        $exchangeRate->setRate(0.9);
        $manager->persist($exchangeRate);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CurrencyFixtures::class,
        ];
    }
}