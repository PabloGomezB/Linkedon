<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Oferta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    #[Route('/setOfertaCandidat', name: 'setOfertaCandidat', methods: ['POST'])]
    public function setOfertaCandidat(Request $request): JsonResponse {

        $data = json_decode($request->getContent(), true);

        $oferta_id = $data['oferta_id'];
        $candidat_id = $data['candidat_id'];

        if (empty($oferta_id) || empty($candidat_id)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $em = $this->getDoctrine()->getManager();

        $candidat = $this->getDoctrine()->getRepository(Candidat::class)->find($candidat_id);
        $oferta = $this->getDoctrine()->getRepository(Oferta::class)->find($oferta_id);

        $candidat->addOferte($oferta);
        $oferta->addCandidat($candidat);

        $em->persist($candidat);
        $em->persist($oferta);

        $em->flush();
        return new JsonResponse(['status' => 'Row creada!'], Response::HTTP_CREATED);
    }
}