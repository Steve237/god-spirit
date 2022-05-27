<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\VideosRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(Request $request, 
    PostRepository $postRepository,
    VideosRepository $videosRepository): Response
    {   
        if($request->isMethod("POST")) {
            $searchContent = $request->request->get("search");
            $posts = $postRepository->findByTitle($searchContent);
            $videos = $videosRepository->findByTitle($searchContent);
        } else {
            return $this->redirectToRoute("home");
        }
        
        return $this->render('search/index.html.twig', [
           "posts" => $posts,
           "videos" => $videos
        ]);
    }
}
