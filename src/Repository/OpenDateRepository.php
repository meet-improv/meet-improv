<?php

namespace App\Repository;

use App\Entity\OpenDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OpenDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpenDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpenDate[]    findAll()
 * @method OpenDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpenDateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OpenDate::class);
    }

//    /**
//     * @return OpenDate[] Returns an array of OpenDate objects
//     */
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
    public function findOneBySomeField($value): ?OpenDate
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
