<?php

namespace App\Repository;

use App\Entity\ColaAtencion1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ColaAtencion1|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColaAtencion1|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColaAtencion1[]    findAll()
 * @method ColaAtencion1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColaAtencion1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColaAtencion1::class);
    }

    // /**
    //  * @return ColaAtencion1[] Returns an array of ColaAtencion1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ColaAtencion1
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
