<?php

namespace App\Repository;

use App\Entity\ColaAtencion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ColaAtencion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColaAtencion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColaAtencion[]    findAll()
 * @method ColaAtencion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColaAtencion1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColaAtencion::class);
    }

    // /**
    //  * @return ColaAtencion[] Returns an array of ColaAtencion objects
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
    public function findOneBySomeField($value): ?ColaAtencion
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
