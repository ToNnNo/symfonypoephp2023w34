<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrailerController extends AbstractController
{
    #[Route('/trailer/{alias}', name: 'trailer_index')]
    public function index(string $alias = null): Response
    {
        $trailers = [
            'ahsoka' => ['title' => "AHSOKA", 'code' => "J_1EXWNETiI"],
            'napoleon' => ['title' => "NAPOLEON", 'code' => "OAZWXUkrjPc"],
            'loki' => ['title' => "Loki", 'code' => "dug56u8NN7g"],
        ];

        $trailer = $trailers[$alias] ?? null;

        return $this->render('trailer/index.html.twig', [
            'trailers' => $trailers,
            'trailer' => $trailer
        ]);
    }
}
