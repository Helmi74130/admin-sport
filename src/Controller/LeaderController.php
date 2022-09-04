<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Entity\Leader;
use App\Entity\Permission;
use App\Form\LeaderType;
use App\Repository\LeaderRepository;
use App\Repository\PermissionRepository;
use App\Security\SecurityAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\EmailVerifier;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class LeaderController extends AbstractController
{

    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }


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
    public function view( ManagerRegistry $doctrine, int $id, Leader $leader, PermissionRepository $permissionRepository): Response
    {
        /**
         * This controller display all leaders
         * @param LeaderRepository $leaderRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

        $leaders = $doctrine->getRepository(Leader::class)->find($id);
        $permissions = $permissionRepository->findAll();//

        $halls = $leader->getHall();

        return $this->render('pages/leader/view.html.twig', [
            'leaders'=> $leaders,
            'halls' => $halls,
            'permissions' => $permissions
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

    #[Route('/gerants/ajouter', name: 'app_ajouter_leader', methods: ['GET', 'POST'])]
    public function add(/*Request $request, EntityManagerInterface $manager*/Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, SecurityAuthenticator $authenticator, EntityManagerInterface $entityManager, MailerInterface $mailer) :Response
    {
        /**
         * This controller show a form for create leader
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @return Response
         */

        $leader = new Leader();
        $form = $this->createForm(LeaderType::class, $leader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $leader->setPassword(
                $userPasswordHasher->hashPassword(
                    $leader,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($leader);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $leader,
                $email= (new TemplatedEmail())
                    ->from(new Address('orangemyapps@gmail.com', 'Orange bleu admin'))
                    ->to($leader->getEmail())
                    ->subject('Confirmer votre adresse mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                    //pass variable user
                    ->context([
                        'user' => $leader
                    ])
            );

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Le gérant a été ajouté avec succès !'
            );

            /*return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );*/
            return $this->redirectToRoute('app_leader');


        }
        return $this->render('pages/leader/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        /**
         * This controller check mail
         * @param TranslatorInterface $translator
         * @param Request $request
         * @return Response
         */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse mail a bien été vérifiée.');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/gerants/editer/{id}', name: 'app_leader_editer', methods: ['GET', 'POST'])]
    public function edit(Leader $leader, Request $request, EntityManagerInterface $manager):Response
    {
        /**
         * This controller edit a leader
         * @param EntityManagerInterface $manager
         * @param Request $request
         * @param Leader $leader
         * @return Response
         */

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

    #[Route('/gerants/supprimer/{id}', name: 'app_supprimer_leader', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Leader $leader):Response
    {
        /**
         * This controller delete a leader
         * @param EntityManagerInterface $manager
         * @param Leader $leader
         * @return Response
         */

        $manager->remove($leader);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le gérant a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_leader');
    }

}

