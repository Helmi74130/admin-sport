<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]

    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('pages/user/home.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/ajouter', name: 'app_user_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $manager) :Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a été a été ajoutée avec succès !'
            );

            return $this->redirectToRoute('app_user');

        }
        return $this->render('pages/user/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]

    public function edit(User $user,EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_user');

        }

        return $this->render('pages/user/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}
