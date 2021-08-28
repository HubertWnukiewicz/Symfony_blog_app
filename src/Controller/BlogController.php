<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
//    #[Route('/blog', name: 'blog')]
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $blogRepository) : Response
    {
        return $this->render(
            'blog/index.html.twig',
            [
                'blogs' => $blogRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/blog/details/{id}", name="blog_details")
     */
    public function getDetails(BlogRepository $blogRepository, string $id) : Response
    {
        return $this->render(
            'blog/details.html.twig',
            [
                'blog' => $blogRepository->find($id),
            ]
        );
    }
}
