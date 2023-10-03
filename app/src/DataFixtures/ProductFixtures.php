<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    private const PRODUCTS_TO_CREATE = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= self::PRODUCTS_TO_CREATE; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setDescription($faker->realText());
            $product->setPrice($faker->numberBetween(100, 10000));
            $product->setImage('img' . rand(1, 5) . '.jpg');
            $product->setSku(mb_strtoupper(substr($faker->uuid, 0, 10)));
            $product->setQuantity($faker->numberBetween(1, 1000));

            $manager->persist($product);
            $manager->flush();
        }
    }
}
