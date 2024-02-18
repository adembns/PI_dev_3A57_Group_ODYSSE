<?php

namespace App\Repository;

use App\Entity\Civilisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Civilisation>
 *
 * @method Civilisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Civilisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Civilisation[]    findAll()
 * @method Civilisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CivilisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Civilisation::class);
    }

//    /**
//     * @return Civilisation[] Returns an array of Civilisation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Civilisation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
