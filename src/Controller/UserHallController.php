<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Repository\HallRepository;
use App\Repository\PermissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserHallController extends AbstractController
{
    #[Route('/utilisateur/salles', name: 'app_user_hall')]
    public function index(PaginatorInterface $paginator, HallRepository $hallRepository, Request $request): Response
    {

        /**
         * This controller display users halls
         * @param HallRepository $hallRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $halls = $paginator->paginate(
            $hallRepository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('pages/user_hall/home.html.twig', [
            'halls' => $halls,
        ]);
    }

    #[Route('/utilisateur/salles/{id}', name: 'app_user_hall_permission')]
    public function modules(Permission $permission, Request $request): Response
    {

        /**
         * This controller display users halls
         * @param HallRepository $hallRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */



        return $this->render('pages/user_hall/module.html.twig', [
            'permissions' => $permission,
        ]);
    }
}
