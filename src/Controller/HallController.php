<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Entity\Permission;
use App\Form\HallType;
use App\Repository\HallRepository;
use App\Repository\LeaderHallRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HallController extends AbstractController
{
    #[Route('/admin/salle', name: 'app_hall', methods: ['GET'])]
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
            // permet de trouver par rapport aux users $hallRepository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('pages/hall/home.html.twig', [
            'halls' => $halls
        ]);
    }

    #[Route('/admin/salle/ajouter', name: 'app_salle_ajouter', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $manager, LeaderHallRepository $leaderHallRepository, MailerInterface $mailer) :Response
    {
        /**
         * This controller show a form for create hall
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @return Response
         */

        $hall = new Hall();

        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $leader = $form->getData()->getLeader()->getUser();
            $leaderHall = $form->getData()->getLeaderHall()->getUser();

            //this condition checks that the leaderHall does not have a hall
            if ($hall->getleaderHall()->getHall()->getId() == null) {

                $permission = new Permission();

                $permission->setIsMembersAdd(1);
                $permission->setIsMembersRead(1);
                $permission->setIsMembersStatistiqueRead(1);
                $permission->setIsMembersWrite(1);
                $permission->setIsPaymentSchedulesAdd(1);
                $permission->setIsSellDrinks(1);
                $permission->setIsPaymentSchedulesWrite(1);
                $permission->setHall($hall);
                $manager->persist($permission);

                $hall = $form->getData();


                $email = (new TemplatedEmail())
                    ->from('orangemyapps@gmail.com')
                    ->to($leader->getEmail())
                    ->subject('Ajout d\'une nouvelle salle')
                    ->htmlTemplate('email/informationHall.html.twig')
                    //pass variable contact
                    ->context([
                        'leader' => $leader
                    ]);

                $emailHall = (new TemplatedEmail())
                    ->from('orangemyapps@gmail.com')
                    ->to($leaderHall->getEmail())
                    ->subject('Ajout d\'une nouvelle salle')
                    ->htmlTemplate('email/informationHall.html.twig')
                    //pass variable contact
                    ->context([
                        'leader' => $leaderHall
                    ]);

                $mailer->send($email);
                $mailer->send($emailHall);

                $manager->persist($hall);

                $manager->flush();
                $this->addFlash(
                    'success-salle',
                    'Votre salle a été ajoutée avec succès !'
                );

                return $this->redirectToRoute('app_hall');
            }else{
                $this->addFlash(
                    'error',
                    'Ce gérant possède déja une salle! Veuillez choisir un autre gérant'
                );
                return $this->redirectToRoute('app_salle_ajouter');
            }

        }
        return $this->render('pages/hall/add.html.twig', [
            'form'=> $form->createView()
        ]);


    }

    #[Route('/admin/salle/editer/{id}', name: 'app_salle_editer', methods: ['GET', 'POST'])]
    public function edit(Hall $hall, Request $request, EntityManagerInterface $manager):Response
    {
        /**
         * This controller edit a hall
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @param Hall $hall
         * @return Response
         */

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

    #[Route('/admin/salle/supprimer/{id}', name: 'app_salle_supprimer', methods: ['GET'])]
    public function delete( EntityManagerInterface $manager, Hall $hall):Response
    {
        /**
         * This controller delete a hall
         * @param EntityManagerInterface $manager
         * @param Hall $hall
         * @return Response
         */

        $manager->remove($hall);
        $manager->flush();

        $this->addFlash(
            'success-salle',
            'Votre salle a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_hall');
    }
}
