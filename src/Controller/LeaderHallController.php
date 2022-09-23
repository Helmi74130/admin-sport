<?php

namespace App\Controller;

use App\Entity\LeaderHall;
use App\Repository\HallRepository;
use App\Repository\LeaderHallRepository;
use App\Repository\PermissionRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LeaderHallController extends AbstractController
{
    #[Route('/admin/gerant/salle', name: 'app_leader_hall', options: ['expose' => true])]
    public function index(LeaderHallRepository $leaderHallRepository, PaginatorInterface $paginator, Request $request, UserRepository $userRepository, HallRepository $hallRepository): Response
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
            20
        );

        $hall = $hallRepository->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $leadersHallSerialze = $serializer->serialize($leadersHall, 'json');


        return $this->render('pages/leader_hall/home.html.twig', [
            'leadersHall' => $leadersHall,
            'hall' => $hall,
            'leadersHallSerialze' => $leadersHallSerialze
        ]);
    }



    #[Route('/admin/salle-gerant/{id}', name: 'app_leader_hall_view', options: ['expose' => true], methods: ['GET'])]
    public function view(ManagerRegistry $doctrine, int $id, PermissionRepository $permissionRepository, HallRepository $hallRepository, LeaderHallRepository $leaderHallRepository): Response
    {

        $leaderHall = $doctrine->getRepository(LeaderHall::class)->find($id);
        return $this->render('pages/leader_hall/view.html.twig', [
            'leaderHall' => $leaderHall,
        ]);
    }

}
