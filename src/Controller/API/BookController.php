<?php

namespace App\Controller\API;

use App\Entity\Book;
use App\Normalizer\BookNormalizer;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/book', name: 'api_book_')]
class BookController extends AbstractController
{

    public function __construct(
        private readonly BookRepository         $bookRepository,
        private readonly AuthorRepository       $authorRepository,
        private readonly GenreRepository        $genreRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly BookNormalizer         $bookNormalizer,
        private readonly SerializerInterface    $serializer,
        private readonly ValidatorInterface     $validator
    )
    {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $books = $this->bookRepository->findAllWithAuthor();

        $context = $this->bookNormalizer->getNormalizeContext();

        return $this->json($books, Response::HTTP_OK, context: $context);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return $this->json(['message' => 'Not Found', 'code' => 404], Response::HTTP_NOT_FOUND);
        }

        $context = $this->bookNormalizer->getNormalizeContext();

        return $this->json($book, Response::HTTP_OK, context: $context);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        // récupère les données dans la requête
        $content = $request->getContent();
        // créer une instance de Book à partir des données
        $book = $this->serializer->deserialize($content, Book::class, 'json');

        $data = json_decode($content, true);

        if(array_key_exists('author', $data)) {
            $author = $this->authorRepository->find($data['author']);
            if ($author != null) {
                $book->setAuthor($author);
            }
        }

        if(array_key_exists('genre', $data)) {
            $genre = $this->genreRepository->find($data['genre']);
            if ($genre != null) {
                $book->setGenre($genre);
            }
        }

        // valider les contraintes
        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            // fait appelle à la méthode __toString()
            $stringErrors = (string)$errors;
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $this->json(['message' => "Created", 'code' => 201], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return $this->json(['message' => 'Not Found', 'code' => 404], Response::HTTP_NOT_FOUND);
        }

        $content = $request->getContent();

        $this->serializer->deserialize($content, Book::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $book
        ]);

        $data = json_decode($content, true);

        if(array_key_exists('author', $data)) {
            $author = $this->authorRepository->find($data['author']);
            if ($author != null) {
                $book->setAuthor($author);
            }
        }

        if(array_key_exists('genre', $data)) {
            $genre = $this->genreRepository->find($data['genre']);
            if ($genre != null) {
                $book->setGenre($genre);
            }
        }

        // valider les contraintes
        $errors = $this->validator->validate($book);
        if (count($errors) > 0) {
            // fait appelle à la méthode __toString()
            $stringErrors = (string)$errors;
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        return $this->json(['message' => "OK", 'code' => 200], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (!$book) {
            return $this->json(['message' => 'Not Found', 'code' => 404], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
