<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user
                ->setUsername($faker->userName)
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    $faker->password
                ))
                ->setFirstName($faker->firstName)
                ->setSurname($faker->lastName)
                ->setEmail($faker->email)
            ;
            $manager->persist($user);
            $this->addReference(User::class . '_' . $i, $user);
        }



        $manager->flush();
    }
}
