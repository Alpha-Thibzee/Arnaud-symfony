<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;
    private $slugger;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
        
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail("admin@admin.fr")
        ->setRoles(["ROLE_ADMIN"])
        ->setPassword($this->hasher->hashPassword($admin, "adminadmin"));
      

        $manager->persist($admin);
        


        $manager->flush();
    }
}

