<?php

namespace App\Repository;

use App\Data\SearchDataMed;
use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;

use Knp\Component\Pager\PaginatorInterface;


/**
 * @method Medecin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medecin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medecin[]    findAll()
 * @method Medecin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Medecin::class);
        $this->paginator = $paginator;
    }

    // /**
    //  * @return Medecin[] Returns an array of Medecin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Medecin
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findwithSpec($value)
    {   $qb=$this->createQueryBuilder('m')
        ->innerJoin('m.Specialite','s')
        ->where('s.id=:spec')
        ->setParameter('spec',$value);
         $query=$qb->getQuery();
         return  $query->getResult();
         }
    public function listOrderByName()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.nom', 'DESC')
            ->getQuery()->getResult();
    }

    public function listOrderById()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->getQuery()->getResult();
    }

    public function rechercher($data)
    {
        return $this->createQueryBuilder('m')
            ->Where('m.nom LIKE  :data')->orWhere('m.prenom LIKE :data')->orWhere('m.id LIKE :data')
            ->setParameter('data', '%'.$data.'%')
            ->getQuery()->getResult();
    }

    /**
     * recupere les medecins
     * @return PaginationInterface
     */
    public function SearchMED(SearchDataMed $search): PaginationInterface
    {

        $query = $this
            ->createQueryBuilder('m')
            ->select('s', 'm')
            ->join('m.Specialite', 's');

        if (!empty($search->q)) {
            $query = $query
                ->Where('m.nom LIKE :q' )->orWhere('m.prenom LIKE :q ')
                ->setParameter('q', "%{$search->q}%");
       
        }

        if (!empty($search->Specialite)) {
            $query = $query
                ->andWhere('s.id IN (:specialite)')
                ->setParameter('specialite', $search->Specialite);
        }


            $query = $query->getQuery();
        return $this->paginator->paginate(
         $query,
            $search->page,
            3

        );



    }
    //SELECT COUNT(m.id) as nb,s.titre FROM medecin m JOIN medecin_specialite ms JOIN specialite s WHERE ms.medecin_id = m.id and s.id=ms.specialite_id GROUP BY ms.specialite_id
    public function getCustomInformations()
    {
        $rawSql = "SELECT COUNT(m.id) as nb,s.titre FROM medecin m JOIN medecin_specialite ms JOIN specialite s WHERE ms.medecin_id = m.id and s.id=ms.specialite_id GROUP BY ms.specialite_id";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }


}
