<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Cocur\Slugify\Slugify;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = ['MMORPG', 'Jeux de Guerre', 'Jeux de Rôles', 'Jeux Enfants', 'Jeux de Sport'];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();
        for ($i = 0; $i < count(self::CATEGORIES); $i++) {
            $category = new Category();
            $category->setName(self::CATEGORIES[$i])
                     ->setDateAdd($faker->dateTimeBetween('-2years', 'now'))
                     ->setSlug($slugify->slugify(self::CATEGORIES[$i]));
            $this->addReference('category' . $i, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
