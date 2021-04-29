<?php

namespace App\Repository;

use App\Entity\Tester;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tester|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tester|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tester[]    findAll()
 * @method Tester[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TesterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tester::class);
    }

     /**
      * @return Tester[] Returns an array of Tester objects
     */



    public function groupbyformation()
    {
        $query = $this->createQueryBuilder('p')
            ->select($this->count('p.*'),'p.formation')
            ->groupBy('p.formation')
            ->getQuery();
        $query->getResult();
    }

    // /**
    //  * @return Tester[] Returns an array of Tester objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tester
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function  addtest($id,$id_test,$formation,$id_user,$date,$note){
        $em=$this->getEntityManager();
        $query=$em->createQuery(
            'INSERT INTO `tester` (`id`, `id_test`, `formation`, `id_user`, `date`, `note`) VALUES (',$id,'',$id_test,'',$formation,'',$id_user,'',$date,'NULL);'
        );
        return $query->getResult();
    }
    public function ct()
    {
        return $this->createQueryBuilder('s')
            ->groupBy('formation')
            ->getQuery()->getResult();
    }


}
