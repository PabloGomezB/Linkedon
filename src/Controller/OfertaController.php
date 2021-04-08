<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Empresa;
use App\Entity\Oferta;
use App\Form\OfertaType;
use App\Repository\OfertaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/oferta')]
class OfertaController extends AbstractController
{
    #[Route('/', name: 'oferta_index', methods: ['GET'])]
    public function index(OfertaRepository $ofertaRepository): Response
    {
        return $this->render('oferta/index.html.twig', [
            'ofertas' => $ofertaRepository->findAll(),
        ]);
    }

    #[Route('/misofertas', name: 'oferta_empresa', methods: ['GET'])]
    public function ofertasPorEmpresa(OfertaRepository $ofertaRepository): Response
    {
        $userLoggedId = $this->getUser()->getId();
        $empresa = $this->getDoctrine()->getRepository(Empresa::class)->findBy(array('usuari' => $userLoggedId));
        $empresaId = $empresa[0]->getId();

        return $this->render('oferta/show.html.twig', [
            'ofertas' => $ofertaRepository->findBy(array('empresa' => $empresaId)),
        ]);
    }

    #[Route('/new', name: 'oferta_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response{
        $ofertum = new Oferta();
        $ofertum->setDataPublicacio(new \DateTime());
        $ofertum->setEstat(0);

        // Pillamos la empresa actualmente logeada y la seteamos en la oferta
        $empresa = $this->getDoctrine()->getRepository(Empresa::class)->findOneBy(['usuari' => $this->getUser()->getId()]);
        $ofertum->setEmpresa($empresa);

        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(OfertaType::class, $ofertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ofertum);
            $entityManager->flush();
            return $this->redirectToRoute('linkedon_index');
        }

        return $this->render('oferta/new.html.twig', [
            'ofertum' => $ofertum,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'oferta_show', methods: ['GET'])]
    public function show(Oferta $ofertum): Response
    {
        return $this->render('oferta/show.html.twig', [
            'ofertum' => $ofertum,
        ]);
    }

    #[Route('/{id}/edit', name: 'oferta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Oferta $ofertum): Response
    {
        $form = $this->createForm(OfertaType::class, $ofertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin/contentTab3');
        }

        return $this->render('oferta/edit.html.twig', [
            'ofertum' => $ofertum,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/misofertas/edit/{id}', name: 'oferta_edit_misofertas', methods: ['GET', 'POST'])]
    public function editMiOferta(Request $request, Oferta $ofertum): Response
    {
        $form = $this->createForm(OfertaType::class, $ofertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('oferta_empresa');
        }

        return $this->render('oferta/edit.html.twig', [
            'ofertum' => $ofertum,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/delete/{id}', name: 'oferta_delete')]
    public function delete(Request $request, Oferta $ofertum): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($ofertum);
        $entityManager->flush();
        return $this->redirectToRoute('oferta_empresa');
    }
}
