<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Trainer;
use App\Entity\Category;
use App\Entity\Course;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CourseFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $course = new Course();
        $course->setName('Symfony');
        $course->setContent('Le développement web côté serveur (avec Symfony)');
        $course->setDuration(10);
        $course->setIsPublished(true);
        $course->setCategory($this->getReference('category-1', Category::class));
        $course->addTrainer($this->getReference('trainer-1', Trainer::class));
        $manager->persist($course);
        
        $course = new Course();
        $course->setName('PHP');
        $course->setContent('Le développement web côté serveur (avec PHP)');
        $course->setDuration(5);
        $course->setIsPublished(false);
        $course->setCategory($this->getReference('category-1', Category::class));
        $course->addTrainer($this->getReference('trainer-2', Trainer::class));
        $manager->persist($course);

        $course = new Course();
        $course->setName('Apache');
        $course->setContent('Administration d\'un serveur Apache sous Linux');
        $course->setDuration(5);
        $course->setIsPublished(true);
        $course->setCategory($this->getReference('category-1', Category::class));
        $course->addTrainer($this->getReference('trainer-3', Trainer::class));
        $manager->persist($course);

        // Création de 30 cours supplémentaires
        for ($i = 1; $i <= 30; $i++) {
            $course = new Course();
            $course->setName($faker->word());
            $course->setContent($faker->realText());
            $course->setDuration(mt_rand(1,10));
            $dateCreated = $faker->dateTimeBetween('-2 months', 'now');
            // NB : dateTimeBetween() retourne un DateTime, il faut donc le convertir en DateTimeImmutable
            $course->setCreatedAt(\DateTimeImmutable::createFromMutable($dateCreated));
            $dateModified = $faker->dateTimeBetween($course->getCreatedAt()->format('Y-m-d'), 'now');
            $course->setModifiedAt(\DateTimeImmutable::createFromMutable($dateModified));
            // Generate random boolean with faker
            $course->setIsPublished($faker->boolean(70));
            $course->setCategory($this->getReference('category-'.mt_rand(1,4), Category::class));
            $course->addTrainer($this->getReference('trainer-'.mt_rand(0,9), Trainer::class));
            $manager->persist($course);
        }

        $manager->flush();
    }
    
    public function getDependencies(): array {
        return [
            CategoryFixtures::class,
            TrainerFixtures::class
        ];
    }
}
