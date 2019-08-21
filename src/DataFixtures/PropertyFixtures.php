<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100 ; $i++) {
            $property = new Property();
            $property->setTitle($faker->words(3, true))
            ->setDescription($faker->sentence(20,true))
            ->setPower($faker->numberBetween(1000, 45000))
            ->setCostCombo($faker->numberBetween(0, 10))
            ->setPowerCombo($faker->numberBetween(500, 1000))
            ->setPrice($faker->numberBetween(1, 250))
            ->setType($faker->numberBetween(0, 3))
            ->setColor($faker->numberBetween(0, 6))
            ->setOrigin($faker->numberBetween(0, 12))
            ->setPersonage($faker->numberBetween(0, 23))
            ->setCostEnergy($faker->numberBetween(0, 10))
            ->setEra($faker->numberBetween(0, 23))
            ->setSeries($faker->numberBetween(0, 15))
            ->setRarity($faker->numberBetween(0, 9))
            ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
