<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setTitle('Maison')
                ;

        $manager->persist($category);

        $type = new Type();
        $type->setTitle('Vente')
                ;
        $manager->persist($type);

        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 12; ++$i) {
            $property = new Property();

            $property->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(15, 250))
                ->setRooms($faker->numberBetween(1, 9))
                ->setPrice($faker->numberBetween(45000, 1500000))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPictures('fake.jpg')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setCategory($category)
                ->setType($type)
                    ;
            $manager->persist($property);
        }

        $manager->flush(); // optimise tout les requête et envoie tout d'un coup
    }
}
