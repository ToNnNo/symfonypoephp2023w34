<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {

        return $this->render('profile/index.html.twig', []);
    }

    #[Route('/users', name: 'users')]
    #[IsGranted('ROLE_ADMIN')]
    public function users(): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('profile/users.html.twig', []);
    }
}
