<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManager;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/article/{slug}", name="show_post")
     */
    public function index(
        Post $post, 
        PostRepository $postRepository, 
        EntityManagerInterface $entityManager): Response
    {
        
        $numberViews = $post->getView();
        
        if(!$numberViews) {
            $views = 1;
       } else {
            $views = $numberViews++;
        }

        $post->setView($views);
        $entityManager->persist($post);
        $entityManager->flush();

        $suggestions = $postRepository->findByCategory($post->getCategory());

        return $this->render('post/show.html.twig', [
           "post" => $post,
           "suggestions" => $suggestions
        ]);
    }
}
