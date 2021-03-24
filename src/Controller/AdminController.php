<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\OfertaRepository;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(OfertaRepository $ofertaRepository): Response
    {
        // return $this->render('admin/index.html.twig', [
        //     'controller_name' => 'AdminController',
        // ]);

        return $this->render('oferta/index.html.twig', [
            'ofertas' => $ofertaRepository->findAll(),
            'ofertasEstat0' => $ofertaRepository->findBy(array('estat' => '0')),
            'ofertasJoin' => $ofertaRepository->findAllJoin(),
        ]);
    }

}
