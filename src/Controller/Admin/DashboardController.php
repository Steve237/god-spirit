<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\About;
use App\Entity\Categories;
use App\Controller\Admin\PostCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin/admin.css');
    }
    
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Option 1. Make your dashboard redirect to the same page for all users
        return $this->redirect($adminUrlGenerator->setController(PostCrudController::class)->generateUrl());
    }
    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Articles', 'fas fa-list', Post::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('A propos', 'fas fa-list', About::class);
    }
}
