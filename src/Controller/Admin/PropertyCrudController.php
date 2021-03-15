<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            IntegerField::new('surface'),
            IntegerField::new('rooms'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('city'),
            TextField::new('address')->hideOnIndex(),
            ImageField::new('pictures')->setBasePath('img')->setUploadDir('/public/img'),
            DateTimeField::new('updatedAt')->hideOnIndex(),
            DateTimeField::new('created_at'),
            AssociationField::new('category'),
            AssociationField::new('type'),
            AssociationField::new('author')->hideOnForm(),
        ];
    }
}
