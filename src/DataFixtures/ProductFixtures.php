<?php

namespace App\DataFixtures;

Use Faker;
use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
    
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $category = $this->getReference('categoryShop-' . '1');
            $product = new Product();
            $product->setTitle($faker->sentence);
            $product->setSlug($faker->slug);
            $product->setContent($faker->text);
            $product->setOnline(true);
            $product->setCreatedAt(new DateTime('now'));
            $product->setSubtitle($faker->text(155));
            $product->setAttachment($faker->imageUrl(650, 480,'merch',true));
            $product->setPrice($faker->randomFloat(2));
            $product->setCategory($category);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
