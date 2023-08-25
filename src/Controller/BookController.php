<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookSearchType;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book', name: 'book_')]
class BookController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        // récupère tous les livres de la table book
        // $books = $bookRepository->findAll();

        $form = $this->createForm(BookSearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $data = $form->getData();

            // récupère tous les livres et auteurs associés qui correspondent à la valeur demandé
            $books = $bookRepository->search($data['q']);
        } else {
            // récupère tous les livres et leurs auteurs associés
            $books = $bookRepository->findAllWithAuthor();
        }

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'bookSearchForm' => $form
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        /*$book
            ->setTitle("Harry Potter à l'école des sorciers")
            ->setSummary("<p>Harry Potter est un garçon ordinaire. Mais, le jour de ses onze ans, son existence
                bascule : un géant vient le chercher pour l'emmener dans une école de sorciers. Voler à cheval sur des 
                balais, jeter des sorts, combattre les Trolls : Harry Potter se révèle être un sorcier vraiment doué.
                </p>")
            ->setPublicationDate(new \DateTime('1997-06-26'));*/

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ) {
            // met l'entité dans la mémoire de doctrine
            $entityManager->persist($book);
            // execute les requêtes
            $entityManager->flush();

            $this->addFlash("success", "Le livre a bien été enregistré");

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/form.html.twig', [
            'bookForm' => $form,  //->createView()
        ]);
    }

    #[Route('/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('book/form.html.twig', [

        ]);
    }

    #[Route('/detail/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function detail(int $id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);

        // $book == null
        if (!$book) {
            throw $this->createNotFoundException();
        }

        return $this->render('book/detail.html.twig', [
            'book' => $book
        ]);
    }

    #[Route('/delete', name: 'delete')]
    public function delete(): Response
    {

        return $this->redirectToRoute('book_index');
    }
}
