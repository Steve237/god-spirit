<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="app_category")
     */
    public function index(CategoriesRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/categories.html.twig', [
            "categories" => $categories
        ]);
    }
}
