<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Categories;
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
    
        if($post->getView() === null) {
            $views = 1;
       } else {
            $views = $post->getView() + 1;
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


    /**
     * @Route("/articles/{category}", name="posts_by_category")
     */
    public function showPostByCategory(
        Categories $category, 
        PostRepository $postRepository): Response
    {
       $posts = $postRepository->findByCategory($category);
        
        return $this->render('post/list.html.twig', [
           "posts" => $posts
        ]);
    }


    /**
     * @Route("/articles", name="posts")
     */
    public function postsList(
        PostRepository $postRepository): Response
    {
       $posts = $postRepository->findAll();
        return $this->render('post/list.html.twig', [
           "posts" => $posts
        ]);
    }
}
