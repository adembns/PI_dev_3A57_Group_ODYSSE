<?php

namespace App\Repository;

use App\Entity\Programe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programe>
 *
 * @method Programe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programe[]    findAll()
 * @method Programe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programe::class);
    }

//    /**
//     * @return Programe[] Returns an array of Programe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Programe
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
