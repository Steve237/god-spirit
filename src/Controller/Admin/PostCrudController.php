<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new Post();
        $entity->setUser($this->getUser());
        return $entity;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureActions(Actions $actions): Actions
    {
        // this action executes the 'renderInvoice()' method of the current CRUD controller
        $showPost = Action::new('Voir', 'Voir')
            ->linkToRoute('show_post', function (Post $post): array {
                return [
                    'slug' => $post->getSlug()
                ];
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $showPost);
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel("Titre");
        yield TextEditorField::new('content')
            ->setLabel("Contenu")
            ->hideOnIndex()
            ->setFormType(CKEditorType::class);
        yield AssociationField::new('category')
            ->setLabel("Catégories");

        if (Crud::PAGE_NEW === $pageName) {
            yield ImageField::new('coverPicture')
                ->setLabel("Image de couverture")
                ->hideOnIndex()
                ->setBasePath('img/uploads')
                ->setUploadDir('public/img/uploads')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]');
        } else {

            yield ImageField::new('coverPicture')
                ->setLabel("Image de couverture")
                ->hideOnIndex()
                ->setBasePath('img/uploads')
                ->setUploadDir('public/img/uploads')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false);
        }

        yield BooleanField::new('showInSlider')
            ->setLabel("Carroussel")
            ->addCssClass('bottom-space');
        yield DateField::new("createdAt")
            ->setLabel("Création")
            ->hideOnForm();
        yield DateField::new("updatedAt")
            ->setLabel("Modification")
            ->hideOnForm();
        yield AssociationField::new("user")
            ->setLabel("Auteur")
            ->hideOnForm();
    }
}
