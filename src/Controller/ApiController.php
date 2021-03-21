<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController {

    #[Route('/getUserLogged', name: 'getUserLogged', methods: ['GET'])]
    public function getUserLogged(): JsonResponse {

        $user = $this->getUser();

        $data = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
