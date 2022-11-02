<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')
            ->setLabel("Nom");

        if (Crud::PAGE_NEW === $pageName) {

            yield UrlField::new('categoryPicture')
                ->setLabel("Image de couverture")
                ->hideOnIndex();
        } else {

            yield UrlField::new('categoryPicture')
                ->setLabel("Image de couverture")
                ->hideOnIndex()
                ->setRequired(false);
        }
    }
}
