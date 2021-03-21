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

    // Control para mandar a las empresas RECIEN REGISTRADAS a completar el registro como empresas (al completar el registro ROLE_UNVERIFIED se eliminará)
    #[Route('/defineRol', name: 'linkedon_defineRol')]
    public function defineRol(): Response {

        if (!is_object($this->get('security.token_storage')->getToken()->getUser())) {
            return $this->redirectToRoute('app_login');
        }

        if(in_array("ROLE_UNVERIFIED", $this->getUser()->getRoles())){
            return $this->redirectToRoute('empresa_new'); // En este controlador se registra la nueva empresa con las crecendiales del user_empresa actual
        }
        else if(in_array("ROLE_EMPRESA", $this->getUser()->getRoles())){
            return $this->redirectToRoute('linkedon_index');
        }
        else{
            return $this->redirectToRoute('linkedon_userloggedview');
        }

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
