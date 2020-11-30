<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USER_COUNT = 40;
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder) {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $password = $this->userPasswordEncoder->encodePassword(new User(), 'password');

        $admin = new User();
        $admin->setEmail('admin@admin.com')
              ->setFirstname('Admin')
              ->setLastname('Admin')
              ->setDateInscription(new \DateTime())
              ->setPassword($this->userPasswordEncoder->encodePassword($admin, 'admin'))
              ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        for ($i = 0; $i < self::USER_COUNT; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                 ->setFirstname($faker->firstName)
                 ->setLastname($faker->lastName)
                 ->setDateInscription(new \DateTime())
                 ->setPassword($password)
                 ->setBiography($i % 2 !== 0 ? null : $faker->paragraph(2));
            $this->addReference('user' . $i, $user);

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
