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

        $blogId = $request->get('blogId');
        $blog = $blogRepository->find($blogId);
        $text = $request->get('comment');

        $comment = new BlogComment();
        $insertTime = new DateTime();
        $comment->setInsertDate(new DateTime());
        $comment->setText($text);
        $comment->setBlogId($blog);
        $comment->setIsVisible(true);
        $blog->addBlogComment($comment);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->persist($blog);
        $entityManager->flush();

        return new Response(
                            "<div class ='card mb-4 box-shadow'>
            <div class='my-0 font-weight-normal'>
                Insert Date: " . $insertTime->format('Y-m-d H:i:s')  . "
            </div>
            <div class='card-body'>
               " . $text . "
            </div>
                        </div>"
        );
    }
}
