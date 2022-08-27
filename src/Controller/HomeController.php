<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('tounsi74130@gmail.com')
            ->to('helmielmaiel@gmail.com')
            ->subject('This e-mail is for testing purpose')
            ->text('This is the text version')
            ->html('<p>This is the HTML version</p>')
        ;

        $mailer->send($email);

        return $this->render('pages/home.html.twig');
    }
}
