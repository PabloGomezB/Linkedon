<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Repository\OfertaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin')]
    public function index(Request $request, OfertaRepository $ofertaRepository): Response
    {
        // return $this->render('admin/index.html.twig', [
        //     'controller_name' => 'AdminController',
        // ]);

        // $uri = $request->getPathInfo();
        // echo str_replace("%23","#",$uri);


        return $this->render('oferta/index.html.twig', [
            'ofertas' => $ofertaRepository->findAll(),
            'ofertasEstat0' => $ofertaRepository->findBy(array('estat' => '0')),
            'ofertasJoin' => $ofertaRepository->findAllJoin(),
        ]);
    }

    #[Route('/admitir/{id}-{publicar}', name: 'admin_admitir')]
    public function admitirOferta($id, $publicar){
        $oferta = new Oferta();
        $entityManager = $this->getDoctrine()->getManager();
        $oferta = $entityManager->getRepository(Oferta::class)->findOneBy(array('id' => $id));
        if ($publicar == 1){
            $oferta->setEstat(1);
        }
        else{
            $oferta->setEstat(2);
        }
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }


    #[Route('/delete/{id}', name: 'admin_delete')]
    public function deleteOferta($id): Response
    {
        // $oferta = new Oferta();
        // $entityManager = $this->getDoctrine()->getManager();
        // $oferta = $entityManager->getRepository(Oferta::class)->findOneBy(array('id' => $id));
        // $entityManager->remove($oferta);
        // $entityManager->flush();

        return $this->redirectToRoute('admin/contentTab3');
    }


    // #[Route('/{id}/edit', name: 'oferta_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Oferta $ofertum): Response
    // {
    //     $form = $this->createForm(OfertaType::class, $ofertum);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('oferta_index');
    //     }

    //     return $this->render('oferta/edit.html.twig', [
    //         'ofertum' => $ofertum,
    //         'form' => $form->createView(),
    //     ]);
    // }
}
