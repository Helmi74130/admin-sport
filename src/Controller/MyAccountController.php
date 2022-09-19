<?php

namespace App\Controller;

use App\Repository\HallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyAccountController extends AbstractController
{
    #[Route('/compte', name: 'app_my_account')]
    public function index(HallRepository $hallRepository): Response
    {
        /**
         * This controller show user halls
         * @param HallRepository $halls
         * @return Response
         */

        $halls =  $hallRepository->findAll();
        $user = $this->getUser();

        return $this->render('pages/my_account/home.html.twig', [
            'halls'=> $halls,
            'user' => $user
        ]);
    }
}
