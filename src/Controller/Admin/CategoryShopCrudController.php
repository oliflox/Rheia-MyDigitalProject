<?php

namespace App\Controller\Admin;

use App\Entity\CategoryShop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryShopCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryShop::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
