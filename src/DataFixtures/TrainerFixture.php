<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trainer;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrainerFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++) {
            $trainer = new Trainer();
            $trainer->setFirstName($faker->firstName());
            $trainer->setLastName($faker->lastName());
            $this->addReference('trainer-'.$i, $trainer);
            $manager->persist($trainer);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            CategoryFixtures::class
        ];
    }
}
