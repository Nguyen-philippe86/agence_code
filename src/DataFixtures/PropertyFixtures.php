<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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

        for ($j = 1; $j <= 5; ++$j) {
            $property = new Property();

            $property->setTitle('Belle Villa de style architecture')
                ->setDescription('Ut ab voluptas sed a nam. Sint autem inventore aut officia aut aut blanditiis. Ducimus eos odit amet et est ut eum.')
                ->setSurface(62)
                ->setRooms(3)
                ->setPrice(332500)
                ->setCity('Le Bouscat')
                ->setAddress('9 avenue du Mal de Lattre de Tassigny')
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
