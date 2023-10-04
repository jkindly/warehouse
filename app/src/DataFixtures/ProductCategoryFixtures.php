<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductCategoryFixtures extends Fixture
{
    private const CATEGORIES_TO_CREATE = 20;

    public function load(ObjectManager $manager)
    {

    }

}
