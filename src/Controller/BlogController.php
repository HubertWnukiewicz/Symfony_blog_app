<?php

namespace App\Controller;

use App\Entity\BlogComment;
use App\Repository\BlogRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $blog = $blogRepository->find($id);

        return $this->render(
            'blog/details.html.twig',
            [
                'blog' => $blog,
                'comments' => $blog->getBlogComments()
            ]
        );
    }

    /**
     * @Route("/blog/insert")
     */
    public function addCommentToBlog(BlogRepository $blogRepository, Request $request)
    {
        $blog = $blogRepository->find(6);


        $comment = new BlogComment();
        $comment->setInsertDate(new DateTime());
        $comment->setText("aaaa");
        $comment->setBlogId($blog);
        $comment->setIsVisible(true);
        $blog->addBlogComment($comment);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->persist($blog);
        $entityManager->flush();

        return new Response(
            'Saved new comment with id: '.$comment->getId()
            .' and new blog with id: '.$blog->getId()
        );
    }
}
