<?php

namespace App\Controller\Admin;

use App\Entity\Videos;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VideosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Videos::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $entity = new Videos();
        $entity->setUser($this->getUser());
        return $entity;
    }

    public function configureActions(Actions $actions): Actions
    {
        // this action executes the 'renderInvoice()' method of the current CRUD controller
        $showPost = Action::new('Voir', 'Voir')
            ->linkToRoute('show_video', function (Videos $video): array {
                return [
                    'slug' => $video->getSlug()
                ];
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $showPost);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel("Titre");
        yield UrlField::new('url')
            ->setLabel("Url youtube de la vidéo");

        yield TextEditorField::new('content')
            ->setLabel("Description")
            ->hideOnIndex();

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

        yield DateField::new("createdAt")
            ->setLabel("Création")
            ->hideOnForm();
        yield DateField::new("updatedAt")
            ->setLabel("Modification")
            ->hideOnForm();
    }
}
