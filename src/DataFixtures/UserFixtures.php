<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher){}
    public function load(ObjectManager $manager): void
    {
        // create ADMIN
        $this->createUser("developer@example.com", "root", ['ROLE_ADMIN'], $manager);

        // create EDITOR
        $this->createUser("editor@example.com", 'editorPassword', ['ROLE_EDITOR'], $manager);

        // create USER
        $this->createUser('user@example.com', 'userPassword', ['ROLE_USER'], $manager);



        $manager->flush();
    }

    public function createUser(string $email, string $password, array $roles, ObjectManager $manager): void
    {
        $user = new User();
         $user->setEmail($email);
         $user->setPassword($this->hasher->hashPassword($user,$password));
         $user ->setRoles($roles);

        $manager->persist($user);
    }
}
