<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $euro = new Currency();
        $euro->setName('Euro');
        $euro->setCode('EUR');
        $euro->setFlag('Flag_of_Europe.svg.png');
        $this->addReference('euro', $euro);
        $manager->persist($euro);

        $dollar = new Currency();
        $dollar->setName('Dollars');
        $dollar->setCode('USD');
        $dollar->setFlag('Flag_of_the_United_States.svg.png');
        $this->addReference('dollar', $dollar);
        $manager->persist($dollar);

        $manager->flush();
    }
}