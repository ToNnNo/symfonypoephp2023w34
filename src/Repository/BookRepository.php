<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findAllWithAuthor(): array
    {
        return $this->createQueryBuilder('book')
            ->select('book')
            ->leftJoin('book.author', 'author')
            ->addSelect('author')
            ->leftJoin('book.genre', 'genre')
            ->addSelect('genre')
            ->orderBy('book.id')
            ->getQuery()
            ->getResult()
        ;
    }

    public function search(string $q): array
    {
        $bookFQCN = Book::class;

        return $this->getEntityManager()
            ->createQuery(<<<SQL
                SELECT book, author, genre
                FROM $bookFQCN book
                LEFT JOIN book.author author
                LEFT JOIN book.genre genre
                WHERE book.title LIKE :title
                ORDER BY book.id
            SQL)
            ->setParameter('title', "%".$q."%")
            ->getResult();
    }


//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
