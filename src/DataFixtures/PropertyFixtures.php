<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PropertyFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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
        for ($i = 1; $i <= 8; ++$i) {
            $property = new Property();

            $property->setTitle($faker->words(3, true))
                ->setDescription($faker->realText(300, 2))
                ->setSurface($faker->numberBetween(15, 250))
                ->setRooms($faker->numberBetween(1, 9))
                ->setPrice($faker->numberBetween(45000, 1500000))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPictures('villa.jpg')
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setCategory($category)
                ->setType($type)
                    ;
            $manager->persist($property);
        }
        $user = new User();

        $user->setUsername($faker->firstName)
            ->setEmail('admin@admin.com')
            ->setPassword($this->encoder->encodePassword($user, 'admin2021'))
            ->setPhone($faker->phoneNumber)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($user);

        $manager->flush();
    }
}
