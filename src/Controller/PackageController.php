<?php

namespace App\Controller;

use App\Repository\BlogLimitRepository;
use App\Repository\PackageTypeRepository;
use App\Repository\UserPaymentsRepository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PackageController extends AbstractController
{
    /**
     * @Route("/packages", name="packages")
     */
    public function index(PackageTypeRepository $packageRepository): Response
    {

        return $this->render('package/index.html.twig',
            [
                'pckTypes' => $packageRepository->findAll()
            ]
        );
    }
    /**
     * @Route("/packages/buy")
     */
    public function buyPackage(
        PackageTypeRepository $packageRepository,
        BlogLimitRepository $limitRepository,
        UserRepository $userRepository,
        UserPaymentsRepository $paymentsRepository,
        Request $request): Response
    {
        $packageId = $request->get('packageId');
        $packageToBuy = $packageRepository->find($packageId);

        //check if the user can buy this package this month
        $user = $userRepository->find(1);//TODO: get user by session info
        $paymentsInCurrentMonth = $paymentsRepository->createQueryBuilder('pl')
            ->where('pl.user_id_id = :userId')
            ->andWhere('pl.purchase_date between "2019-01-01" and "2022-10-10"')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

        //add Payment to db




        //correct current_limit value
//        $userCurrentLimit = $limitRepository->findOneBy(['user_id' => $user->getId()]);
//        $userCurrentLimit += $packageToBuy->getPackageLimit();
//        $userCurrentLimit->setCurrentLimit($userCurrentLimit);
//
//
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->persist($userCurrentLimit);
//        $entityManager->persist($paymentsRepository);
//        $entityManager->flush();
        return new Response(json_encode($user));
    }
}
