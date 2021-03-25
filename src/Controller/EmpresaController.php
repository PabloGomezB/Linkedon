<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use App\Repository\EmpresaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/empresa')]
class EmpresaController extends AbstractController {
    #[Route('/', name: 'empresa_index', methods: ['GET'])]
    public function index(EmpresaRepository $empresaRepository): Response {
        return $this->render('empresa/index.html.twig', [
            'empresas' => $empresaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'empresa_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger): Response {
        $empresa = new Empresa();
        $userLogged = $this->getUser();
        // Hacemos set al objeto empresa con los datos de la empresa logeado actualmente para poder hacer las foreign keys
        $empresa->setCorreu($userLogged->getEmail()); // Se pilla el correo del user logeado
        $empresa->setUsuari($userLogged); // Se pilla el user logeado (por defecto va a buscar el metodo _toString de User y obtiene el id)
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logoFile = $form->get('logo')->getData();

            // this condition is needed because the 'logo' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($logoFile) {
                $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $logoFile->guessExtension();

                // Move the file to the directory where logos are stored
                try {
                    $logoFile->move(
                        $this->getParameter('logos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'logoFilename' property to store the PDF file name
                // instead of its contents
                $empresa->setLogo($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($empresa);
            $entityManager->flush();

            // Intenté hacer update desde aquí a User pero se quejaba, por eso redirecciono a su controlador
            return $this->redirectToRoute('user_verify'); // Redirect al UserController donde se quitará el ROLE_UNVERIFIED al user actual
        }

        return $this->render('empresa/new.html.twig', [
            'empresa' => $empresa,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'empresa_show', methods: ['GET'])]
    public function show(Empresa $empresa): Response {
        return $this->render('empresa/show.html.twig', [
            'empresa' => $empresa,
        ]);
    }

    #[Route('/{id}/edit', name: 'empresa_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Empresa $empresa): Response {
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('empresa/edit.html.twig', [
            'empresa' => $empresa,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'empresa_delete', methods: ['DELETE'])]
    public function delete(Request $request, Empresa $empresa): Response {
        if ($this->isCsrfTokenValid('delete' . $empresa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($empresa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('empresa_index');
    }
}
