<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/route', name: 'route_')]
class RouteController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {


        return $this->render('route/index.html.twig', []);
    }

    // [^0-9] => toutes les caractères sauf les valeurs numériques
    // + => 1 ou plus
    #[Route('/{name}', name: 'name', requirements: ['name' => '[^0-9\.!?;:/=]+'], priority: -1)]
    public function showName($name): Response
    {
        $name = ucfirst($name);

        return $this->render('route/name.html.twig', [
            'name' => $name
        ]);
    }

    // \d => les valeurs de O à 9
    // + => 1 ou plus
    #[Route('/{id}', name: 'name_id', requirements: ['id' => '\d+'], priority: -1)]
    public function showNameById(int $id): Response
    {
        $users = [
            1 => "Léa",
            2 => "Souhail",
            3 => "Arnaud"
        ];

        $name = $users[$id];

        return $this->render('route/name.html.twig', [
            'name' => $name
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {

        return $this->render('route/contact.html.twig', []);
    }

    #[Route('/list/{page}', name: 'list', defaults: ['title' => "Hello"])] // , defaults: ['page' => 1]
    public function list(string $title, int $page = 1): Response
    {

        return $this->render('route/list.html.twig', [
            'title' => $title,
            'page' => $page
        ]);
    }
}
