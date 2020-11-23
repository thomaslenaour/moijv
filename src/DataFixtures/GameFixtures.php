<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Game;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $game = new Game();
            $game->setName($faker->text(25))
                 ->setDescription($faker->paragraph(3))
                 ->setDateAdd($faker->dateTimeBetween('-2years', 'now'))
                 ->setUser($this->getReference('user' . random_int(0, UserFixtures::USER_COUNT - 1)))
                 ->setCategory($this->getReference('category' . random_int(0, count(CategoryFixtures::CATEGORIES) - 1)));
            
            $manager->persist($game);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            UserFixtures::class,
            CategoryFixtures::class
        ];
    }
}
