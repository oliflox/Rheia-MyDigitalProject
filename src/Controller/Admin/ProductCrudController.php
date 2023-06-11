<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('online'),
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            AssociationField::new('category'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('attachmentFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('attachment')->setBasePath('/uploads/attchments')->onlyOnIndex(),
            TextEditorField::new('content'),
            TextareaField::new('subtitle'),
            DateField::new('createdAt'),
        ];
    }
    
}
