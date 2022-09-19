<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Repository\HallRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserHallController extends AbstractController
{

    #[Route('/modules', name: 'app_user_module', methods: ['GET'])]
    public function index(HallRepository $hallRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /**
         * This controller display all permissions
         * @param HallRepository $hallRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $halls = $paginator->paginate(
            $hallRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );
        $user = $this->getUser();

        return $this->render('pages/user_hall/hallmodule.html.twig', [
            'halls'=> $halls,
            'user' => $user
        ]);
    }

    #[Route('/salles', name: 'app_user_hall_test', methods: ['GET'])]
    public function salle(HallRepository $hallRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /**
         * This controller display hall for leaders only
         * @param HallRepository $hallRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $halls = $paginator->paginate(
            $hallRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );
        $user = $this->getUser();

        return $this->render('pages/user_hall/hall.html.twig', [
            'halls'=> $halls,
            'user' => $user
        ]);
    }

    #[Route('/salles/{id}', name: 'app_user_hall_permission')]
    public function modules($id, ManagerRegistry $doctrine, Request $request): Response
    {
        /**
         * This controller display users halls
         * @param HallRepository $hallRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $hall = $doctrine->getRepository(Hall::class)->find($id);

        return $this->render('pages/user_hall/module.html.twig', [
            'hall' => $hall,
        ]);
    }
}
