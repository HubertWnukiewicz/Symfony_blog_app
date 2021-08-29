<?php

namespace App\Controller;

use App\Entity\Blog;
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
     * @Route("/", name="blogs")
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
    public function addCommentToBlog(BlogRepository $blogRepository, Request $request): Response
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

    /**
     * @Route("/blog/changeTitle")
     */
    public function changeBlogTitle(BlogRepository $blogRepository, Request $request): Response
    {
        $blogId = $request->get('blogId');
        $blog = $blogRepository->find($blogId);
        $title = $request->get('title');
        $blog->setTitle($title);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($blog);
        $entityManager->flush();

        return new Response($title);
    }

    /**
     * @Route("/blog/changeContent")
     */
    public function changeBlogContent(BlogRepository $blogRepository, Request $request): Response
    {
        $blogId = $request->get('blogId');
        $blog = $blogRepository->find($blogId);
        $newContent = $request->get('blogContent');
        $blog->setText($newContent);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($blog);
        $entityManager->flush();

        return new Response($newContent);
    }

    /**
     * @Route("/blog/add", name="add_new_blog")
     */
    public function addNewBlogPage(BlogRepository $blogRepository) : Response
    {
        return $this->render(
            'blog/add.html.twig'
        );
    }

    /**
     * @Route("/blog/insertNew")
     */
    public function addNewBlog(BlogRepository $blogRepository, Request $request): Response
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $blog = new Blog();
        $blog->setText($content);
        $blog->setTitle($title);
        $blog->setInsertDate(new DateTime());


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($blog);
        $entityManager->flush();

        return new Response($blog->getId());
    }

    /**
     * @Route("/blog/search/direct")
     */
    public function directSearch(BlogRepository $blogRepository, Request $request): Response
    {
        $word = $request->get('term');
        $ret = [];
        $results = $blogRepository->createQueryBuilder('b')
            ->where('b.title LIKE :word')
            ->orWhere('b.text LIKE :word')
            ->setParameter('word', '%' . $word . '%')
            ->getQuery()
            ->getResult();

        foreach($results as $result) {
            $ret[] = [
                'id' => $result->getId(),
                'label' => $result->getTitle(),
                'value' => $result->getId(),];
        }
        return new Response(json_encode($ret));
    }

    /**
     * @Route("/blog/search/elastic")
     */
    public function elasticSearch(BlogRepository $blogRepository, Request $request): Response
    {
        $blogId = $request->get('blogId');
        $term = $request->get('term');
        $blog = $blogRepository->find($blogId);
        $text = $blog->getText();
        $ret = explode(" ",$text);

        $retString = '<div>';
        foreach ($ret as $word) {
            similar_text($word, $term, $perc);
            if ($perc < 75) {
                $retString .= $word;
            } else if ($perc >= 75 && $perc < 85) {
                $retString .= '<span style="background: orange">' . $word .' </span>';
            } else if ($perc >= 85 && $perc < 95) {
                $retString .= '<span style="background: yellow">' . $word .' </span>';
            } else {
                $retString .= '<span style="background: green">' . $word .' </span>';
            }
            $retString .= ' ';
        }
        $retString .= '</div>';
        return new Response($retString);
    }
}
