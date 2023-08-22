<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestController extends AbstractController
{
    #[Route('/request', name: 'request_index')]
    public function index(Request $request): Response
    {
        // Pour débugger on utilise la fonction dump()
        // |_ le résultat s'affiche dans le profiler
        // Attention ! On ne concerve pas les dump() en production !!
        // dump($request);

        $name = ucfirst($request->query->get('name', "world"));

        return $this->render('request/index.html.twig', [
            'name' => $name
        ]);
    }

    #[Route('/request/session', name: 'request_session')]
    public function session(Request $request): Response
    {
        if($request->query->has('value')) {
            $session = $request->getSession();
            $value = $request->query->get('value');

            $session->set('value', $value);

            // enregistre un message flash dans la session
            $this->addFlash('success', "La valeur a bien été sauvegardée");

            return $this->redirectToRoute('request_session');
        }

        return $this->render('request/session.html.twig', []);
    }

    #[Route('/request/session/show', name: 'request_session_show')]
    public function show(Request $request): Response
    {
        $session = $request->getSession();

        $value = $session->get('value', 'Aucune valeur sauvegardée');

        return $this->render('request/show.html.twig', [
            'value' => $value
        ]);
    }
}
