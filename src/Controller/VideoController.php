<?php

namespace App\Controller;

use App\Entity\Videos;
use App\Repository\VideosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    /**
     * @Route("/videos", name="app_videos")
     */
    public function index(
        VideosRepository $videosRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response
    {
        $videosList = $videosRepository->findAll();
        $videos = $paginator->paginate(
            $videosList,
            $request->query->getInt('page', 1), 
            20 
        );
        
        return $this->render('video/videos.html.twig', [
            "videos" => $videos
        ]);
    }

    /**
     * @Route("/video/{slug}", name="show_video")
     */
    public function show(
        Videos $video,
        EntityManagerInterface $entityManager
    ): Response {

        if ($video->getView() === null) {
            $views = 1;
        } else {
            $views = $video->getView() + 1;
        }

        $video->setView($views);
        $entityManager->persist($video);
        $entityManager->flush();

        return $this->render('video/show.html.twig', [
            "video" => $video
        ]);
    }
}
