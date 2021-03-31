<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    // /**
    //  * @return Offre[] Returns an array of Offre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
/*
    public function search($term)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.prix LIKE  :searchTerm')
            ->setParameter('searchTerm', '%'.$term.'%')
            ->getQuery()
            ->execute()
            ;
    }
*/public function listOrderByCClinique()
{
    return $this->createQueryBuilder('s')
     ->GroupBy('s.clinique')->getQuery()->getResult();

   /* $em=$this->getEntityManager();
    $query=$em->createQuery(
        'SELECT clinique from App\Entity\Offre clinique GROUP BY clinique'
    );
    return $query->getResult();*/





}
    public function listOrderByDate()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date >   :date1')
            ->setParameter('date1', new \DateTime('now'))
            ->orderBy('s.date', 'DESC')
            ->getQuery()->getResult();
    }

    public function DateExpr()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date >   :date1')
            ->setParameter('date1', new \DateTime('now'))
            ->getQuery()->getResult();
    }
    public function SearchName($data)
    {
        return $this->createQueryBuilder('c')
            ->where('c.prix LIKE  :data')
            ->orWhere('c.date LIKE  :data ')


            ->setParameter('data', '%'.$data.'%')
            ->getQuery()->getResult()
            ;
    }




}
