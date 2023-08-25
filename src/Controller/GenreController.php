<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre', name: 'genre_', requirements: ['id' => '\d+'])]
class GenreController extends AbstractController
{
    public function __construct(
        private readonly GenreRepository        $repository,
        private readonly EntityManagerInterface $entityManager
    ){ }


    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $genres = $this->repository->findAll();

        return $this->render('genre/index.html.twig', [
            'genres' => $genres
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($genre);
            $this->entityManager->flush();

            $this->addFlash("success", "Le genre a bien été enregistré");

            return $this->redirectToRoute('genre_index');
        }

        return $this->render('genre/form.html.twig', [
            'genreForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(int $id, Request $request): Response
    {
        $genre = $this->repository->find($id);

        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();

            $this->addFlash("success", "Le genre a bien été modifié");
        }

        return $this->render('genre/form.html.twig', [
            'genreForm' => $form
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(int $id, Request $request): Response
    {
        $genre = $this->repository->find($id);
        $token = $request->query->get('token');

        if($this->isCsrfTokenValid('delete-genre', $token)) {
            $this->entityManager->remove($genre);
            $this->entityManager->flush();
            $this->addFlash("success", "Le genre a bien été supprimé");
        }

        return $this->redirectToRoute('genre_index');
    }
}
