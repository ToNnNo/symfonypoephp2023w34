<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResponseController extends AbstractController
{
    #[Route('/response', name: 'response_index')]
    public function index(): Response
    {

        // render retourne un objet de type Response
        return $this->render('response/index.html.twig', [
            'controller_name' => 'ResponseController',
        ]);
    }

    #[Route('/response/json', name: 'response_json')]
    public function jsonResponse(): JsonResponse
    {
        $user = ['firstname' => "John", 'lastname' => "Doe", 'email' => "john.doe@gmail.com"];

        // return $this->json($user);

        return new JsonResponse($user);
    }

    #[Route('/response/file', name: 'response_file')]
    public function fileResponse(): BinaryFileResponse
    {

        // return $this->file('download/cafe.jpg');

        return new BinaryFileResponse('download/cafe.jpg');
    }

    #[Route('/response/redirection', name: 'response_redirection')]
    public function redirection(): RedirectResponse
    {

        return $this->redirectToRoute('response_json');
    }
}
