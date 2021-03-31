<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('category', 'Catégorie'))
            ->add(EntityFilter::new('type', 'Type'))
            ->add(TextFilter::new('city', 'Ville'))
            ->add(NumericFilter::new('price', 'Prix'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            TextEditorField::new('description', 'Description'),
            IntegerField::new('surface', 'Surface'),
            IntegerField::new('rooms', 'Pièce(s)'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            TextField::new('city', 'Ville'),
            TextField::new('address', 'Adresse')->hideOnIndex(),
            ImageField::new('pictures', 'Photo')->setBasePath('img')->setUploadDir('/public/img'),
            DateTimeField::new('updatedAt', 'Modifier le')->hideOnIndex(),
            DateTimeField::new('created_at', 'Crée le'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('type', 'Type'),
            AssociationField::new('author', 'Auteur')->hideOnForm(),
        ];
    }
}
