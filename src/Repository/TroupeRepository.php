<?php

namespace App\Repository;

use App\Entity\Troupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Troupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Troupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Troupe[]    findAll()
 * @method Troupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TroupeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Troupe::class);
    }

//    /**
//     * @return Group[] Returns an array of Group objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Group
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
