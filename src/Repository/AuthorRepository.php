<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function listAuthorByEmail():array
    {
    //$query=$this->createQuery("SELECT a FROM App:Author a WHERE a.email LIKE '%".$search."%'");
    return $this->createQueryBuilder('a')
        ->orderBy('a.email','ASC')
        ->getQuery()
        ->getResult();
    }
    public function findAuthorByBookCountRange($min,$max)
    {
        $entityManager = $this->getEntityManager();
        $dql="SELECT a FROM App\Entity\Author a WHERE a.nb_books BETWEEN :min AND :max";
        $query= $entityManager->createQuery($dql)
        ->setParameters(['min'=>$min,'max'=>$max]);
        return $query->getResult();
    }
    public function delete()
    {
        $entityManager = $this->getEntityManager();
        $dql="delete from App\Entity\Author a where a.nb_books = 0";
        $query = $entityManager->createQuery($dql);
        return $query->getResult();
    }
}
