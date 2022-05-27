<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Categories;
use Doctrine\ORM\EntityManager;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
        EntityManagerInterface $entityManager
    ): Response {

        if ($post->getView() === null) {
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
        PostRepository $postRepository
    ): Response {
        $posts = $postRepository->findByCategory($category);

        return $this->render('post/list.html.twig', [
            "posts" => $posts
        ]);
    }


    /**
     * @Route("/articles", name="posts")
     */
    public function postsList(
        PostRepository $postRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $postsList = $postRepository->findAll();
        $posts = $paginator->paginate(
            $postsList, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            20 // Nombre de résultats par page
        );

        return $this->render('post/list.html.twig', [
            "posts" => $posts
        ]);
    }
}
