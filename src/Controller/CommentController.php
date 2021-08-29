<?php

namespace App\Controller;

use App\Repository\BlogCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/hide")
     */
    public function hideComment(BlogCommentRepository $commentRepository, Request $request): Response
    {
        $commentId = $request->get('commentId');
        $comment = $commentRepository->find($commentId);
        $comment->setIsVisible(false);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        return new Response((int)false,Response::HTTP_OK);
    }

    /**
     * @Route("/comment/show")
     */
    public function showComment(BlogCommentRepository $commentRepository, Request $request): Response
    {
        $commentId = $request->get('commentId');
        $comment = $commentRepository->find($commentId);
        $comment->setIsVisible(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        return new Response((int)true, Response::HTTP_OK);
    }

    /**
     * @Route("/comment/remove")
     */
    public function removeComment(BlogCommentRepository $commentRepository, Request $request): Response
    {
        $commentId = $request->get('commentId');
        $comment = $commentRepository->find($commentId);
        if ($comment) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return new Response(true, Response::HTTP_OK);
    }
}
