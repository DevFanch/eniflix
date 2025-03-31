<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Développement web');
        $this->addReference('category-1', $category);
        $manager->persist($category);
        
        $category1 = new Category();
        $category1->setName('Système et réseau');
        $this->addReference('category-2', $category1);
        $manager->persist($category1);
        
        $category2 = new Category();
        $category2->setName('Paillettes');
        $this->addReference('category-3', $category2);
        $manager->persist($category2);
        
        $category3 = new Category();
        $category3->setName('Cybersécurité');
        $this->addReference('category-4', $category3);

        $manager->persist($category3);

        $manager->flush();
    }
}
