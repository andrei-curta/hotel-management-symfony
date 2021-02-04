<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("test@gmail.com");
        $user->setPassword("Test");
        $manager->persist($user);

        $manager->flush();
    }
}