<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Hall;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailAccessController extends AbstractController
{
    #[Route('admin/mail/access', name: 'app_mail_access')]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        return $this->render('mail_access/home.html.twig', [
            'contacts'=> $contacts
        ]);
    }

    #[Route('/admin/mail/supprimer/{id}', name: 'app_mail_supprimer', methods: ['GET'])]
    public function delete( EntityManagerInterface $manager, Contact $contact):Response
    {
        /**
         * This controller delete a mail
         * @param EntityManagerInterface $manager
         * @param Contact $contact
         * @return Response
         */

        $manager->remove($contact);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'e-mail a été supprimé avec succès'
        );

        return $this->redirectToRoute('app_mail_access');
    }
}
