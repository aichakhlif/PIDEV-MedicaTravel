<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method patient[]    findAll()
 * @method patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?patient
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Requete QueryBuilder
     */
/*
     public function findorderbymail(){
         return $this->createQueryBuilder('p')
             ->orderBy('p.email',"ASC")
             ->getQuery()->getResult();
     }
    public function patientorder(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.cin',"ASC")
            ->getQuery()->getResult();
    }
    public function search($cin){
        return $this->createQueryBuilder('p')
            ->andWhere('p.cin LIKE :cin')
            ->setParameter('cin','%'.$cin.'%')
            ->getQuery()
            ->getResult();
    }
    /*
    public function searchclass($classroom){
        return $this->createQueryBuilder('s')
            ->andWhere('s.classroom = :classroom')
            ->setParameter('classroom',$classroom)
            ->getQuery()
            ->getResult();
    }
*/
}
