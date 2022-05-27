<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="app_category")
     */
    public function index(
        CategoriesRepository $categoryRepository, 
        Request $request, 
        PaginatorInterface $paginator
    ): Response
    {
        $categoriesList = $categoryRepository->findAll();

        $categories = $paginator->paginate(
            $categoriesList, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );
        return $this->render('category/categories.html.twig', [
            "categories" => $categories
        ]);
    }
}
