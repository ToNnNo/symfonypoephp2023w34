<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SandboxController extends AbstractController
{
    #[Route('/sandbox', name: 'sandbox_index')]
    public function index(): Response
    {
        $url = $this->generateUrl("sandbox_index");
        $urlAbsolue = $this->generateUrl("sandbox_index", referenceType: UrlGeneratorInterface::ABSOLUTE_URL);

        $sandboxDetailUrl = $this->generateUrl("sandbox_detail");
        $sandboxNotFoundUrl = $this->generateUrl("sandbox_notfound");
        $sandboxUnauthorizedUrl = $this->generateUrl("sandbox_unauthorized");
        $sandboxInternalServerErrorUrl = $this->generateUrl("sandbox_internal_server_error");

        return new Response(<<<EOF
            <html lang="fr">
                <body>
                    <h1>Sandbox Controller !</h1>
                    <p>Hello World</p>
                    <hr />
                    <p>URL relative = $url</p>
                    <p>URL absolue = $urlAbsolue</p>
                    <ul>
                        <li>
                            <a href="$url">Accéder à la page Sandbox</a>
                        </li>
                        <li>
                            <a href="$sandboxDetailUrl">Accéder à la page Sandbox détail</a>
                        </li>
                        <li>
                            <a href="$sandboxNotFoundUrl">Accéder à la page Sandbox Not Found (404)</a>
                        </li>
                        <li>
                            <a href="$sandboxUnauthorizedUrl">Accéder à la page Sandbox Authorized (401)</a>
                        </li>
                        <li>
                            <a href="$sandboxInternalServerErrorUrl">
                                Accéder à la page Sandbox Internal Server Error (500)</a>
                        </li>
                    </ul>
                </body>
            </html>
        EOF);
    }

    #[Route('/sandbox/detail', name: 'sandbox_detail')]
    public function detail(): Response
    {
        $sandboxUrl = $this->generateUrl("sandbox_index");

        return new Response(<<<EOF
            <html lang="fr">
                <body>
                    <h1>Sandbox Détail !</h1>
                    <p>
                        <a href="$sandboxUrl">Retouner à la page Sandbox</a>
                    </p>
                </body>
            </html>
        EOF);
    }

    #[Route('/sandbox/notfound', name: 'sandbox_notfound')]
    public function notFound(): Response
    {
        // erreur 404
        throw $this->createNotFoundException("Ceci n'est pas une erreur");

    }

    #[Route('/sandbox/unauthorized', name: 'sandbox_unauthorized')]
    public function unauthorized(): Response
    {
        // erreur 401
        throw $this->createAccessDeniedException("Accès refusé");

    }

    #[Route('/sandbox/internal_server_error', name: 'sandbox_internal_server_error')]
    public function internalServerError(): Response
    {
        // erreur 500
        throw new \Exception('Internal Server Error');

    }


}













