<?php

namespace App\Controller;

use App\Service\RandomMessage;
use App\Service\SendEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service', name: 'service_')]
class ServiceController extends AbstractController
{
    public function __construct(
        private readonly SendEmail $sendEmail
    ){}

    #[Route('', name: 'index')]
    public function index(RandomMessage $randomMessage): Response
    {
        $message = $randomMessage->getMessage();

        return $this->render('service/index.html.twig', [
            'message' => $message
        ]);
    }

    #[Route('/mail', name: 'send_random_message')]
    public function sendRandomMessage(): Response
    {
        $message = $this->sendEmail->send();

        $this->addFlash('success', 'Le message a bien été envoyé');

        return $this->render('service/send_random_message.html.twig', [
            'message' => $message
        ]);
    }
}
