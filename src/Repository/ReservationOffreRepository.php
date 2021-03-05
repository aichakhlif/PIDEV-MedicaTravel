<?php

namespace App\Repository;

use App\Entity\ReservationOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationOffre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationOffre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationOffre[]    findAll()
 * @method ReservationOffre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationOffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationOffre::class);
    }

    // /**
    //  * @return ReservationOffre[] Returns an array of ReservationOffre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationOffre
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
