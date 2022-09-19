<?php

namespace App\Controller;

use App\Entity\Leader;
use App\Entity\LeaderHall;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
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
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class UserController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        /**
         * This controller display all users
         * @param UserRepository $userRepository
         * @param PaginatorInterface $paginator
         * @param Request $request
         * @return Response
         */

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
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, SecurityAuthenticator $authenticator, EntityManagerInterface $entityManager, MailerInterface $mailer) :Response
    {
        /**
         * This controller create users, hash password and send mail
         * @param EntityManagerInterface $entityManager
         * @param UserAuthenticatorInterface $userAuthenticator
         * @param Request $request
         * @param UserPasswordHasherInterface $userPasswordHasher
         * @param MailerInterface $mailer
         * @param SecurityAuthenticator $authenticator
         * @return Response
         */

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                $email= (new TemplatedEmail())
                    ->from(new Address('orangemyapps@gmail.com', 'Orange bleu admin'))
                    ->to($user->getEmail())
                    ->subject('Confirmer votre adresse mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                    //pass variable user
                    ->context([
                        'user' => $user
                    ])
            );

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Le gérant de salle a été ajouté avec succès !'
            );

            /*return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );*/ //a ne pas decommenter

            //add a new leader or a new leaderhall with the user is flush
            $name = $user->getName();
            $civility = $user->getCivility();
            $firstname = $user->getFirstname();
            $phone= $user->getPhone();
            $active = $user->isIsActive();
            $city = $user->getCity();
            $mail = $user->getEmail();

            foreach ($user->getRoles() as $role) {
                if ($role === 'ROLE_LEADER'){
                    $leader= new Leader();
                    $user = $form->getData();

                    $leader->setName($name)
                        ->setFirstname($firstname)
                        ->setCivility($civility)
                        ->setCity($city)
                        ->setPhone($phone)
                        ->setEmail($mail)
                        ->setIsActive($active)
                        ->setUser($user);

                    $entityManager->persist($leader);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_user');
                }else{
                    $leaderHall= new LeaderHall();
                    $user = $form->getData();

                    $leaderHall->setName($name)
                        ->setFirstname($firstname)
                        ->setCivility($civility)
                        ->setCity($city)
                        ->setPhone($phone)
                        ->setEmail($mail)
                        ->setIsActive(true)
                        ->setUser($user);

                    $entityManager->persist($leaderHall);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_user');
                }
            }
            return $this->redirectToRoute('app_user');
        }
        return $this->render('pages/user/add.html.twig', [
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

    #[Route('/user/{id}', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(User $user,EntityManagerInterface $manager, Request $request): Response
    {
        /**
         * This controller edit a User
         * @param EntityManagerInterface $manager
         * @param User $user
         * @param Request $request
         * @return Response
         */

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_user');

        }

        return $this->render('pages/user/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/user/supprimer/{id}', name: 'app_user_delete', methods: ['GET'])]
    public function delete( EntityManagerInterface $manager, User $user):Response
    {
        /**
         * This controller delete a User
         * @param EntityManagerInterface $manager
         * @param User $user
         * @return Response
         */

        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'utilisateur a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_user');
    }
}
