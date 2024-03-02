<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\orm\OptimisticLockException;

class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    /**
     * Recherche les hôtels en fonction des critères spécifiés.
     *
     * @param string $query La chaîne de recherche
     * @return Hotel[] Les hôtels correspondants à la recherche
     */
    public function search(string $query): array
    {
        return $this->createQueryBuilder('h')
            ->where('h.nom LIKE :query')
            ->orWhere('h.location LIKE :query')
            ->orWhere('h.prix LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }
    public function paginationQuery()
            {
                return $this->createQueryBuilder('p')
                    ->orderBy('p.id', 'ASC')
                    ->getQuery()
                ;
            }
}
