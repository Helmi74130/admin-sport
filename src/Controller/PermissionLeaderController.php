<?php

namespace App\Controller;

use App\Entity\PermissionLeader;
use App\Form\PermissionLeaderType;
use App\Repository\PermissionLeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermissionLeaderController extends AbstractController
{
    #[Route('admin/permission/gerants', name: 'app_permission_leader')]
    public function index(PaginatorInterface $paginator, Request $request, PermissionLeaderRepository $permissionLeaderRepository): Response
    {
        /**
         * This controller display all halls
         * @param PermissionLeaderRepository $permissionLeaderRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $leaderPermissions = $paginator->paginate(
            $permissionLeaderRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('permission_leader/home.html.twig', [
            'leaderPermissions' => $leaderPermissions
        ]);
    }

    #[Route('/admin/permission/gerants/{id}', name: 'app_permission_leader_edit', methods: ['GET', 'POST'])]
    public function edit(PermissionLeader $permissionLeader, Request $request, EntityManagerInterface $manager):Response
    {
        /**
         * This controller edit a hall
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @param PermissionLeader $permissionLeader
         * @return Response
         */

        $form = $this->createForm(PermissionLeaderType::class, $permissionLeader);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $permissionLeader = $form->getData();

            $manager->persist($permissionLeader);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les permissions ont été modifiées avec succès !'
            );

            return $this->redirectToRoute('app_user');

        }

        return $this->render('permission_leader/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }


}
