<?php

namespace App\Controller;

use App\Service\RandomMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service', name: 'service_')]
class ServiceController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(RandomMessage $randomMessage): Response
    {
        $message = $randomMessage->getMessage();

        return $this->render('service/index.html.twig', [
            'message' => $message
        ]);
    }
}
