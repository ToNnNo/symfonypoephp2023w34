<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twig', name: 'twig_')]
class TwigController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        $notifications = [];
        $user = ['firstname' => "John", 'lastname' => "Doe", 'email' => "john.doe@gmail.com"];

        $html = "<b>Hello</b> World";

        return $this->render('twig/index.html.twig', [
            'name' => "John",
            'user' => $user,
            'notifications' => $notifications,
            'html' => $html
        ]);
    }
}
