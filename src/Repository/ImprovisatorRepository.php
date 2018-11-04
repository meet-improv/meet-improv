<?php

namespace App\Repository;

use App\Entity\Improvisator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Improvisator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Improvisator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Improvisator[]    findAll()
 * @method Improvisator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImprovisatorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Improvisator::class);
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
