<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Form\HallType;
use App\Repository\HallRepository;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HallController extends AbstractController
{
    #[Route('/salle', name: 'app_hall', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request, HallRepository $hallRepository): Response
    {
        /**
         * This controller display all halls
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
        return $this->render('pages/hall/home.html.twig', [
            'halls' => $halls
        ]);
    }

    /**
     * This controller show a form for create hall
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */

    #[Route('/salle/ajouter', name: 'app_salle_ajouter', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $manager) :Response
    {
        $hall = new Hall();

        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $hall = $form->getData();

            $manager->persist($hall);
            $manager->flush();

            $this->addFlash(
                'success-salle',
                'Votre salle a été ajoutée avec succès !'
            );

            return $this->redirectToRoute('app_hall');

        }
        return $this->render('pages/hall/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * This controller edit a permission
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Hall $hall
     * @return Response
     */

    #[Route('/salle/editer/{id}', name: 'app_salle_editer', methods: ['GET', 'POST'])]
    public function edit(Hall $hall, Request $request, EntityManagerInterface $manager):Response
    {

        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $hall = $form->getData();

            $manager->persist($hall);
            $manager->flush();

            $this->addFlash(
                'success-salle',
                'Votre salle a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_hall');

        }

        return $this->render('pages/hall/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * This controller delete a hall
     * @param EntityManagerInterface $manager
     * @param Hall $hall
     * @return Response
     */

    #[Route('/salle/supprimer/{id}', name: 'app_salle_supprimer', methods: ['GET'])]
    public function delete( EntityManagerInterface $manager, Hall $hall):Response
    {

        $manager->remove($hall);
        $manager->flush();

        $this->addFlash(
            'success-salle',
            'Votre salle a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_hall');
    }
}
