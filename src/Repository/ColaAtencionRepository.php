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
            $resultado = $entityManager->createQuery('SELECT count(C.id) FROM App\Entity\ColaAtencion C')
                ->getSingleScalarResult();
        }catch(NoResultException $e){
            return 0;
        }
        return $resultado;
    }

    /**
     * Cuenta todos los tikects guardados en el sistema, indicados por un número de cola.
     * @param int $numeroCola
     * @return integer Cantidad total de tickets.
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAllByNumberCola(int $numeroCola):int
    {
        try{
            $cantidadTickets = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.numeroCola = :valor')
                ->setParameter('valor', $numeroCola)
                ->getQuery()
                ->getSingleScalarResult();
        }catch(NoResultException $e){
            return 0;
        }
        return $cantidadTickets;
    }

    /**
     * Paginar resultados. Este método regresa una cantidad de registros indicados por el parametro $inicio.
     * @param int $inicio Indice de inicio de la busqueda.
     * @param int $fin Cantidad de registros ha buscar.
     * @return array Arreglo con el resultado de la busqueda.
     */
    public function paginarColaAtencion(int $inicio, int $fin, int $numeroCola):array
    {
        return $this->createQueryBuilder('c')
            ->where('c.numeroCola = :valor')
            ->setParameter('valor', $numeroCola)
            ->orderBy('c.id', 'ASC')
            ->setFirstResult($inicio)
            ->setMaxResults($fin)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $numeroCola Indica el número de la cola.
     * @return array Arreglo con el resultado de la busqueda.
     */
    public function todosColaAtencion(int $numeroCola):array
    {
        return $this->createQueryBuilder('c')
            ->where('c.numeroCola = :valor')
            ->setParameter('valor', $numeroCola)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Busca un registro por el nombre.
     * @param string $value
     * @return ColaAtencion|null Regresa el objeto encontrado o nulo.
     */
    public function findOneByNombre(string $value): ?ColaAtencion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.nombre = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Encuentra el primer registro.
     * @param int $numeroCola
     * @return ColaAtencion|null Regresa el objeto encontrado o nulo.
     */
    public function findFirst(int $numeroCola): ?ColaAtencion
    {
        return $this->createQueryBuilder('c')
            ->where('c.numeroCola = :valor')
            ->setParameter('valor', $numeroCola)
            ->setFirstResult(1)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
