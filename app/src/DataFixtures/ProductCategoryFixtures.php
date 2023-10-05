<?php

namespace App\DataFixtures;

use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductCategoryFixtures extends Fixture
{
    public const PRODUCT_CATEGORY_REFERENCE = 'product-category';

    public const CATEGORIES_TO_CREATE = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::CATEGORIES_TO_CREATE; $i++) {
            $category = new ProductCategory();
            $category->setName('Category ' . $i);

            $manager->persist($category);
            $manager->flush();

            $this->addReference(self::PRODUCT_CATEGORY_REFERENCE . $i, $category);
        }
    }
}
