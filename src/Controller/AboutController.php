<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="app_about")
     */
    public function index(AboutRepository $aboutRepository): Response
    {   
        $about = $aboutRepository->findAll();
        return $this->render('about/index.html.twig', [
            "about" => $about
        ]);
    }
}
