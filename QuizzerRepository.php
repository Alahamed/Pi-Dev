<?php

namespace App\Repository;

use App\Entity\Quizzer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quizzer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quizzer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quizzer[]    findAll()
 * @method Quizzer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quizzer::class);
    }

    // /**
    //  * @return Quizzer[] Returns an array of Quizzer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quizzer
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
