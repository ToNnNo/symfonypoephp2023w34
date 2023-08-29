<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('', name: 'translation_')]
class TranslationController extends AbstractController
{
    #[Route('/{_locale}/translation', name: 'index')]
    public function index(TranslatorInterface $translator): Response
    {
        $welcome = $translator->trans('welcome in our app');

        return $this->render('translation/index.html.twig', [
            'welcome' => $welcome
        ]);
    }

    #[Route(path: [
        'en' => '/about-us',
        'fr' => '/a-propos'
    ], name: 'about')]
    public function about(): Response
    {

        return $this->render('translation/about.html.twig');
    }
}
