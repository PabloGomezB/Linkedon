<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkedonController extends AbstractController
{
    #[Route('/', name: 'linkedon')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'LinkedonController',
        ]);
    }
}
