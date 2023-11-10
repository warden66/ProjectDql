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
public function booksListByAuthors()
{
    return $this->createQueryBuilder('b')
        ->leftJoin('b.author','a')
        ->addSelect('a')
        ->orderBy('a.username','ASC')
        ->addOrderBy('b.title','ASC')
        ->getQuery()
        ->getResult();
}
public function nb_books()
{
    $entityManager=$this->getEntityManager();
    $query=$entityManager->createQuery("SELECT COUNT(b) as bookCount from App\Entity\book b where b.category = 'Romance'" );
    return $query->getSingleScalarResult();
}
public function findBooksBeforeYearWithAuthorHavingMoreThanTenBooks()
{
    return $this->createQueryBuilder('b')
        ->leftJoin('b.author','a')
        ->andWhere('b.publicationDate < :year')
        ->groupBy('a.id')
        ->having('count(a) >10')
        ->setParameter('year', new \DateTime('2023-01-01'))
        ->getQuery()
        ->getResult();
}
public function findBooksPublishedBetweenDates()
    {
        $startDate = new \DateTime('2014-01-01');
        $endDate = new \DateTime('2018-12-31');

        $entityManager = $this->getEntityManager();

        $dql = "SELECT b 
                FROM App\Entity\Book b 
                WHERE b.publicationDate BETWEEN :startDate AND :endDate";

        $query = $entityManager->createQuery($dql)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate);

        return $query->getResult();
    }

}

