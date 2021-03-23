<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @Route ("/user")
 */
// #[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // Problema: Al modificar el user actual symfony hace logout automatico por seguridad
    // Solución: Guardamos la info del user actual y forzamos al login con la misma info despues de cambiar la base de datos
    /**
     * @Route("/verify", name="user_verify")
     */
    // #[Route('/verify', name: 'user_verify')]
    public function update(): Response
    {
        // Guardamos las credenciales del usuario actualmente logeado (user con ROLE_UNVERIFIED)
        $user = $this->getUser();
        $isEmpresa = false;

        if(in_array("ROLE_UNVERIFIED", $user->getRoles())){
            // Preparamos para modificar el user en la base de datos
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($this->getUser());

            if (!$user) {
                throw $this->createNotFoundException(
                    'Error con el user. No existe el usuario (estoy en UserController)'
                );
            }

            // Le quitamos el ROLE_UNVERIFIED sobreescribiendole el rol correspondiente
            if (in_array("ROLE_EMPRESA", $user->getRoles())){
                $user->setRoles(array('ROLE_EMPRESA'));
            }
            else{
                $user->setRoles(array('ROLE_USER'));
            }

            // Actualizamos el user actual con el nuevo rol en la base de datos y por consiguiente symfony nos hace logout
            $entityManager->flush();
            // Si ahora hacemos $this->getUser(); para obtener la info del ususario que hemos modificado daría error porque ya no hay sesion activa.
            
            // Creamos token de seguridad con la info del user previamente obtenida
            $token = new UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());// Here, "main" is the name of the firewall in your security.yml
            // Seteamos el token
            $this->container->get('security.token_storage')->setToken($token);
            // Y lo registramos en la sesion actual (logeamos)
            $this->container->get('session')->set('_security_main', serialize($token));

            // Finalmente redirigimos al user donde corresponda
            if ($isEmpresa === true){
                return $this->redirectToRoute('oferta_new');
            }
            return $this->redirectToRoute('linkedon_defineRol');            
        }
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    // #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    // #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
