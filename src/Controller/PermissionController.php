<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermissionController extends AbstractController
{
    #[Route('/permission', name: 'app_permission', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /**
         * This controller display all permissions
         * @param PermissionRepository $permissionRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $permissions = $paginator->paginate(
            $permissionRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('pages/permission/home.html.twig', [
            'permissions' => $permissions
        ]);
    }

    #[Route('/permission/ajouter', name: 'app_ajouter', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $manager) :Response
    {
        /**
         * This controller show a form for create permission
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @return Response
         */

        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $permission = $form->getData();

            $manager->persist($permission);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre permission a été ajoutée avec succès !'
            );

            return $this->redirectToRoute('app_leader');

        }
        return $this->render('pages/permission/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/permission/editer/{id}', name: 'app_editer', methods: ['GET', 'POST'])]
    public function edit(Permission $permission, Request $request, EntityManagerInterface $manager):Response
    {
        /**
         * This controller edit a permission
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @param Permission $permission
         * @return Response
         */

        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $permission = $form->getData();

            $manager->persist($permission);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre permission a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_leader');

        }

        return $this->render('pages/permission/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

}
