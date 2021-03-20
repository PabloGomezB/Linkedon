<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkedonController extends AbstractController {
    #[Route('/', name: 'linkedon_index')]
    public function index(): Response {
        if (is_object($this->get('security.token_storage')->getToken()->getUser())) {
            return $this->redirectToRoute('linkedon_userloggedview');
        }

        return $this->render('index.html.twig', [
            'controller_name' => 'LinkedonController',
        ]);
    }
    #[Route('/UserLoggedView', name: 'linkedon_userloggedview')]
    public function userLoggedView(): Response {
        if (!is_object($this->get('security.token_storage')->getToken()->getUser())) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('index.html.twig', [
            'controller_name' => 'LinkedonController',
        ]);
    }
}
