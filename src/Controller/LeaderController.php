<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Entity\Leader;
use App\Entity\Permission;
use App\Form\LeaderType;
use App\Repository\HallRepository;
use App\Repository\LeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
//use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class LeaderController extends AbstractController
{
    #[Route('/gerants', name: 'app_leader', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request, LeaderRepository $leaderRepository): Response
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
            6
        );

        return $this->render('pages/leader/home.html.twig', [
            'leaders' => $leaders
        ]);
    }


    #[Route('/gerants/appercu/{id}', name: 'app_leader_view', methods: ['GET'])]
    public function view( ManagerRegistry $doctrine, int $id, Leader $leader): Response
    {
        /**
         * This controller display all leaders
         * @param LeaderRepository $leaderRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $leaders = $doctrine->getRepository(Leader::class)->find($id);

        $halls = $leader->getHall();

        return $this->render('pages/leader/view.html.twig', [
            'leaders'=> $leaders,
            'halls' => $halls,
        ]);
    }

    #[Route('/gerants/salle/{id}', name: 'app_leader_view_salle', methods: ['GET'])]
    public function salle( ManagerRegistry $doctrine, int $id, Permission $leader): Response
    {
        /**
         * This controller display all leaders
         * @param LeaderRepository $leaderRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $leaders = $doctrine->getRepository(Hall::class)->find($id);

        $halls = $leader->getHall();



        return $this->render('pages/leader/viewperm.html.twig', [
            'leaders'=> $leaders,
            'halls' => $halls,
        ]);
    }

    /**
     * This controller show a form for create leader
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */

    #[Route('/gerants/ajouter', name: 'app_ajouter_leader', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $manager) :Response
    {
        $leader = new Leader();
        $form = $this->createForm(LeaderType::class, $leader);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $leader = $form->getData();

            $manager->persist($leader);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre gérant a été ajoutée avec succès !'
            );

            return $this->redirectToRoute('app_leader');

        }
        return $this->render('pages/leader/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }


    /**
     * This controller edit a leader
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Leader $leader
     * @return Response
     */

    #[Route('/gerants/editer/{id}', name: 'app_leader_editer', methods: ['GET', 'POST'])]
    public function edit(Leader $leader, Request $request, EntityManagerInterface $manager):Response
    {

        $form = $this->createForm(LeaderType::class, $leader);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $leader = $form->getData();

            $manager->persist($leader);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le gérant a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_leader');

        }

        return $this->render('pages/leader/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * This controller delete a leader
     * @param EntityManagerInterface $manager
     * @param Leader $leader
     * @return Response
     */

    #[Route('/gerants/supprimer/{id}', name: 'app_supprimer_leader', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Leader $leader):Response
    {
        $manager->remove($leader);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le gérant a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_leader');
    }

}

