<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/profile/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        /**
         * This controller send mail for contact
         * @param EntityManagerInterface $manager
         * @param MailerInterface $mailer
         * @param Request $request
         * @return Response
         */

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();

            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('orangemyapps@gmail.com')
                ->subject($contact->getSubject())
                ->htmlTemplate('email/contact.html.twig')

                //pass variable contact
                ->context([
                    'contact' => $contact
                ]);

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé avec succès!'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('pages/contact/home.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
