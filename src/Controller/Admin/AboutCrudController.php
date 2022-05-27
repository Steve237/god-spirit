<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Repository\AboutRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AboutCrudController extends AbstractCrudController
{   
    private AboutRepository $aboutRepository;
    
    public function __construct(AboutRepository $aboutRepository) {
    
        $this->aboutRepository = $aboutRepository;
    }
    
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureCrud(Crud $crud): Crud
    {   
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureActions(Actions $actions): Actions
    {
        $about = $this->aboutRepository->findAll();
        
        if($about) {
            
            return $actions
                ->disable(Action::NEW);
        }
        
        return $actions
            ->disable(Action::SAVE_AND_ADD_ANOTHER);
    }

    public function configureFields(string $pageName): iterable
    {   
        yield TextField::new('title')
            ->setLabel("Titre");
        yield TextEditorField::new('content')
            ->setLabel("contenu")
            ->hideOnIndex();
        yield DateField::new("createdAt")
            ->setLabel("Création")
            ->hideOnForm();
        yield DateField::new("updatedAt")
            ->setLabel("Modification")
            ->hideOnForm();
        
        if (Crud::PAGE_NEW === $pageName) {
        
        yield ImageField::new('picture')
            ->setLabel("Image de couverture")
            ->hideOnIndex()
            ->setBasePath('img/uploads')
            ->setUploadDir('public/img/uploads')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->addCssClass('bottom-space');

        } else {

            yield ImageField::new('picture')
            ->setLabel("Image de couverture")
            ->hideOnIndex()
            ->setBasePath('img/uploads')
            ->setUploadDir('public/img/uploads')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->addCssClass('bottom-space')
            ->setRequired(false);
        }
    }
}
