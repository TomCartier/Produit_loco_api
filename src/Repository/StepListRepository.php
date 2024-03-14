<?php

namespace App\Repository;

use App\Entity\StepList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StepList>
 *
 * @method StepList|null find($id, $lockMode = null, $lockVersion = null)
 * @method StepList|null findOneBy(array $criteria, array $orderBy = null)
 * @method StepList[]    findAll()
 * @method StepList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StepListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StepList::class);
    }

//    /**
//     * @return StepList[] Returns an array of StepList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StepList
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
