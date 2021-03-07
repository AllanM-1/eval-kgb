<?php

namespace App\Repository;

use App\Entity\Mission;
use App\Entity\MissionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

     /**
      * @return Mission[] Returns an array of Mission objects
      */
    public function findMissionsList(int $offset, int $limit, string $search, string $sort, string $order)
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->join('m.type', 'mt');

        // Search
        if($search !== '') {
            $queryBuilder->andWhere('m.title LIKE :search')
                ->orWhere('m.code LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        // Sort
        if($sort !== '' && $order !== '') {
            switch ($sort) {
                case 'code' :
                case 'status' :
                case 'title' :
                case 'country' :
                case 'start' :
                case 'end' :
                    $queryBuilder->orderBy('m.'.$sort, $order);
                    break;
                case 'type' :
                    $queryBuilder->orderBy('mt.name', $order);
                    break;
                default :
                    $queryBuilder->orderBy('m.idMission', 'ASC');
            }
        } else {
            $queryBuilder->orderBy('m.idMission', 'ASC');
        }

        // limit
        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    /**
     * @return int Returns the count without limit filter
     */
    public function countMissionsList(string $search)
    {
        $result = 0;
        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder->select('count(m.idMission)');

        // Search
        if($search !== '') {
            $queryBuilder->andWhere('m.title LIKE :search')
                ->orWhere('m.code LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        // Sort
        $queryBuilder->orderBy('m.idMission', 'ASC');

        $query = $queryBuilder->getQuery();
        return $query->getSingleScalarResult();
    }

    /*
    public function findOneBySomeField($value): ?Mission
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
