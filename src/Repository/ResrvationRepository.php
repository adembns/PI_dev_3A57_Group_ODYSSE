<?php

namespace App\Repository;

use App\Entity\Resrvation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Resrvation>
 *
 * @method Resrvation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resrvation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resrvation[]    findAll()
 * @method Resrvation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResrvationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resrvation::class);
    }

//    /**
//     * @return Resrvation[] Returns an array of Resrvation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Resrvation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
