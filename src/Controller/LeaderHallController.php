<?php

namespace App\Controller;

use App\Entity\Leader;
use App\Entity\LeaderHall;
use App\Repository\HallRepository;
use App\Repository\LeaderHallRepository;
use App\Repository\PermissionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaderHallController extends AbstractController
{
    #[Route('/gerant/salle', name: 'app_leader_hall')]
    public function index(LeaderHallRepository $leaderHallRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /**
         * This controller display all leaders
         * @param LeaderHallRepository $leaderRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $leadersHall = $paginator->paginate(
            $leaderHallRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('pages/leader_hall/home.html.twig', [
            'leadersHall' => $leadersHall,
        ]);
    }



    #[Route('/teste/{id}', name: 'app_leader_hall_view', methods: ['GET'])]
    public function view(ManagerRegistry $doctrine, int $id, PermissionRepository $permissionRepository, HallRepository $hallRepository, LeaderHallRepository $leaderHallRepository): Response
    {

        $leaderHall = $doctrine->getRepository(LeaderHall::class)->find($id);
        return $this->render('pages/leader_hall/view.html.twig', [
            'leaderHall' => $leaderHall,
        ]);
    }

}
