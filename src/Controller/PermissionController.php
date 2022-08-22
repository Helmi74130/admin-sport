<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
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
         * This function display all permissions
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
    public function add() :Response
    {
        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
        return $this->render('pages/permission/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
