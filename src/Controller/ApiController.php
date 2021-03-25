<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Empresa;
use App\Entity\Oferta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


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
    public function setOfertaCandidat(Request $request)//: JsonResponse
    {

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

        // Obtener el correo de la empresa que ha publicado la oferta
        $empresa = $oferta->getEmpresa();
        $empresa_email = $empresa->getCorreu();

        // Obtener el cv del candidato con id->candidat_id
        // .....
        
        // Redirect a sendEmail() pasandole como parametros los datos necesarios
        return $this->redirectToRoute('sendEmail', array('candidat_id' => $candidat_id, 'empresa_email' => $empresa_email));

        // return new JsonResponse(['status' => 'Row creada!'], Response::HTTP_CREATED);
    }

    #[Route('/email/{candidat_id}-{empresa_email}', name: 'sendEmail',)]
    public function sendEmail(MailerInterface $mailer, $candidat_id = 0, $empresa_email = ""): JsonResponse {

        // $email = (new Email())
        //     ->from('linkedon.inspedralbes@gmail.com')
        //     ->to('a18pabgombra@inspedralbes.cat') // Substituir por $empresa_email
        //     ->subject('Nuevo candidato en tu oferta')
        //     ->text('wtf es esto?')
        //     ->html('<p>Usuario inscrito en tu oferta</p>'); // Datos del usuario (CV)
        // $mailer->send($email);

        return new JsonResponse(['status' => 'Email Enviado!', 'candidat_id' => $candidat_id, 'empresa_email' => $empresa_email], Response::HTTP_OK);
    }
}
