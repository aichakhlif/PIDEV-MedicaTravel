<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    // /**
    //  * @return Intervention[] Returns an array of Intervention objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intervention
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findSearch(SearchData $search)
    {

        $query = $this
            ->createQueryBuilder('i')
            ->select('s', 'i')
            ->join('i.Specialite', 's');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('i.description LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }






        if (!empty($search->Specialite)) {
            $query = $query
                ->andWhere('s.id IN (:specialite)')
                ->setParameter('specialite', $search->Specialite);
        }

        return
            $query->getQuery()->getResult()


        ;
    }
}
