<?php

namespace App\Repository;

use App\Entity\Clinique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clinique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clinique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clinique[]    findAll()
 * @method Clinique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CliniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clinique::class);
    }

    // /**
    //  * @return Clinique[] Returns an array of Clinique objects
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
    public function findOneBySomeField($value): ?Clinique
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function SearchName($data)
    {
        return $this->createQueryBuilder('c')
            ->where('c.nom LIKE  :data')
            ->orWhere('c.adresse LIKE  :data ')
            ->orWhere('c.tel LIKE  :data ')


            ->setParameter('data', '%'.$data.'%')
            ->getQuery()->getResult()
            ;
    }
    public function categorie()
    {
        return $this->createQueryBuilder('c')
            ->where('c.specialite LIKE  :data')
            ->setParameter('data', '%visage%')
            ->getQuery()->getResult()
            ;
    }
    public function categorie1()
    {
        return $this->createQueryBuilder('c')
            ->where('c.specialite LIKE  :data')
            ->setParameter('data', '%poitrine%')
            ->getQuery()->getResult()
            ;
    }
    public function categorie2()
    {
        return $this->createQueryBuilder('c')
            ->where('c.specialite LIKE  :data')
            ->setParameter('data', '%fesses%')
            ->getQuery()->getResult()
            ;
    }
}
