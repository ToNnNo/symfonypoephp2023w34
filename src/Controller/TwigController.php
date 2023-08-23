<?php

namespace App\Controller;

use App\ValueObject\Contact;
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

    #[Route('/next', name: 'next')]
    public function next(): Response
    {
        $user = ['firstname' => "John", 'lastname' => "Doe", 'email' => "john.doe@gmail.com"];
        $contact = new Contact("Jean", "Dupond", "jean.dupond@gmail.com", "06 118 218 00");

        return $this->render('twig/next.html.twig', [
            'user' => $user,
            'contact' => $contact
        ]);
    }
}
