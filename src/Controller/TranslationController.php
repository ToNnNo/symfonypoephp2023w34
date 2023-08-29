<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale}/translation', name: 'translation_')]
class TranslationController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(TranslatorInterface $translator): Response
    {
        $welcome = $translator->trans('welcome in our app');

        return $this->render('translation/index.html.twig', [
            'welcome' => $welcome
        ]);
    }
}
