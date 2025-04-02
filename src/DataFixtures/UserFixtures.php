<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hashI;
    private $faker;

    public function __construct(
        UserPasswordHasherInterface $hashI
    ){
        $this->hashI = $hashI;
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@eniflex.com');
        $admin->setFirstName('Hell');
        $admin->setLastName('Teacher');
        $admin->setPassword($this->hashI->hashPassword($admin, 'Hell123!'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
    
        $planner = new User();
        $planner->setEmail('planner@eniflex.com');
        $planner->setFirstName('Hervé');
        $planner->setLastName('Planner');
        $planner->setPassword($this->hashI->hashPassword($planner, '000000'));
        $planner->setRoles(['ROLE_PLANNER']);
        $planner->setIsVerified(true);
    
        $lambda = new User();
        $lambda->setEmail('jorges@eniflex.com');
        $lambda->setFirstName('Jorges');
        $lambda->setLastName('User');
        $lambda->setPassword($this->hashI->hashPassword($lambda, 'Salsa123!'));
        $lambda->setRoles(['ROLE_USER']);
        $lambda->setIsVerified(true);

        $manager->persist($admin);
        $manager->persist($planner);
        $manager->persist($lambda);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setPassword($this->hashI->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerified(true);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
