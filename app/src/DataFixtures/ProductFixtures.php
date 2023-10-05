<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private const PRODUCTS_TO_CREATE = 200;

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
            $product->setProductCategory(
                $this->getReference(
                    ProductCategoryFixtures::PRODUCT_CATEGORY_REFERENCE . rand(
                        1,
                        ProductCategoryFixtures::CATEGORIES_TO_CREATE
                    )
                )
            );

            $manager->persist($product);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            ProductCategoryFixtures::class,
        ];
    }
}
