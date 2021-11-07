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
class ColaAtencionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColaAtencion::class);
    }

    /**
     * Cuenta todos los tikects guardados en el sistema.
     * @return integer Cantidad total de tickets.
     */
    public function contarTodos():int
    {
        $entityManager = $this->getEntityManager();
        try{
            $resultado = $entityManager->createQuery('SELECT count(a.id) FROM App\Entity\ColaAtencion C')
                ->getSingleScalarResult();
        }catch(NoResultException $e){
            return 0;
        }
        return $resultado;
    }

    /**
     * Paginar resultados. Este método regresa una cantidad de registros indicados por el parametro $inicio.
     * @param int $inicio Indice de inicio de la busqueda.
     * @param int $fin Cantidad de registros ha buscar.
     * @return array Arreglo con el resultado de la busqueda.
     */
    public function paginarColaAtencion($inicio, $fin):array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC')
            ->setFirstResult($inicio)
            ->setMaxResults($fin)
            ->getQuery()
            ->getResult()
            ;
    }

    /***
    public function findOneByNombre($value): ?ColaAtencion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.nombre = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
