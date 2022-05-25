<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
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
        
        yield ImageField::new('categoryPicture')
        ->setLabel("Image de couverture")
        ->hideOnIndex()
        ->setBasePath('img/uploads')
        ->setUploadDir('public/img/uploads')
        ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]');
}
    
}
