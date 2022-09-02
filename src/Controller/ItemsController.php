<?php

namespace App\Controller;

use App\Repository\LeaderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    #[Route('/items', name: 'app_items', methods: ['GET'])]
    public function index(LeaderRepository $leaderRepository, PaginatorInterface $paginator, Request $request): Response
    {

        /**
         * This controller display all leaders
         * @param LeaderRepository $leaderRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $leaders = $paginator->paginate(
            $leaderRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('pages/items/home.html.twig', [
            'leaders' => $leaders,
        ]);
    }

}
