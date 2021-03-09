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
    public function findMissionsList(int $offset, int $limit, string $search, string $sort, string $order, string $status, string $country, string $type)
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

        // Filters
        if($status !== '') {
            $queryBuilder->andWhere('m.status = :status')
                ->setParameter('status', $status);
        }
        if($country !== '') {
            $queryBuilder->andWhere('m.country = :country')
                ->setParameter('country', $country);
        }
        if($type !== '') {
            $queryBuilder->andWhere('m.type = :type')
                ->setParameter('type', $type);
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
    public function countMissionsList(string $search, string $status, string $country, string $type)
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

        // Filters
        if($status !== '') {
            $queryBuilder->andWhere('m.status = :status')
                ->setParameter('status', $status);
        }
        if($country !== '') {
            $queryBuilder->andWhere('m.country = :country')
                ->setParameter('country', $country);
        }
        if($type !== '') {
            $queryBuilder->andWhere('m.type = :type')
                ->setParameter('type', $type);
        }

        // Sort
        $queryBuilder->orderBy('m.idMission', 'ASC');

        $query = $queryBuilder->getQuery();
        return $query->getSingleScalarResult();
    }

    public function findStatusValues()
    {
        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder->distinct(true);
        $queryBuilder->select('m.status');
        $queryBuilder->orderBy('m.status', 'ASC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findCountryValues()
    {
        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder->distinct(true);
        $queryBuilder->select('m.country');
        $queryBuilder->orderBy('m.country', 'ASC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
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
