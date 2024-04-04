<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Farm;
use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FarmFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Pour avoir de fausses données
        $faker = Factory::create('fr_FR');

        // Tableau de noms de fruits
        $fruits = ['Pomme', 'Banane', 'Orange', 'Raisin', 'Fraise'];

        // Création d'une catégorie
        $categorie1 = new Categorie();
        $categorie1->setName('Fruits');
        $manager->persist($categorie1);

        for ($i = 0; $i < 3; $i++) {
            $farm = new Farm();
            $farm->setName('Ferme de ' . $faker->lastName());
            $farm->setEmail($faker->email());
            $farm->setPhone('06 ' . substr($faker->numerify('## ## ## ## ##'), 0, 8));
            $farm->setStreet($faker->streetAddress());
            $farm->setCity($faker->city());
            $farm->setPostCode($faker->postcode());
            $farm->setCountry('France');
            $farm->setDateCreation(new DateTime());
            $manager->persist($farm);

            for ($j = 0; $j < 5; $j++) {
                $product = new Product();
                $product->setFarm($farm);
                $product->setName($fruits[$j]);
                $product->setDescription($faker->sentence());
                $product->setPicture(null);
                $product->setPrice($faker->randomFloat(2, 0, 100));
                $product->setStock($faker->randomNumber(2, false));
                $product->setCreationDate(new DateTime());
                $product->setCategorie($categorie1);
                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
