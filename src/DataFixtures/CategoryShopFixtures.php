<?php
namespace App\DataFixtures;

use App\Entity\CategoryShop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryShopFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $c = [
            1 => [
                'name' => 'merch',
                'slug' => 'merch'
            ]
            ];

            foreach($c as $k => $value){
                $categoryShop = new CategoryShop();
                $categoryShop->setName($value['name']);
                $categoryShop->setSlug($value['slug']);
                $manager->persist($categoryShop);
                $this->addReference('categoryShop-' . $k, $categoryShop);
            }

        $manager->flush();
    }
}