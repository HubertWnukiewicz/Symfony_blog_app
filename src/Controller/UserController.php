<?php

namespace App\Controller;

use App\Repository\BlogLimitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/user/{id}", name="user_page")
     */
    public function userEditView(UserRepository $userRepository, BlogLimitRepository $limitRepository, string $id): Response
    {
        $user = $userRepository->find($id);

        $userLimit = $limitRepository->findOneBy(['user_id' => $user->getId()]);

        return $this->render(
            'user/view.html.twig',
            [
                'user' => $userRepository->find($id),
                'userLimits' => $userLimit->getCurrentLimit()
            ]
        );
    }


}
