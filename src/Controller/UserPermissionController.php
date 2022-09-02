<?php

namespace App\Controller;

use App\Repository\HallRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPermissionController extends AbstractController
{
    #[Route('/utilisateur/permission', name: 'app_user_permission')]
    public function index(HallRepository $hallRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /**
         * This controller display all permissions
         * @param HallRepository $hallRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $permissions = $paginator->paginate(
            $hallRepository->findBy(['user'=> $this->getUser()]),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('pages/user_permission/home.html.twig', [
            'permissions' => $permissions,
        ]);
    }
}
