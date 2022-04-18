<?php

namespace App\Repository;

use App\Entity\Categoryarticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoryarticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoryarticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoryarticles[]    findAll()
 * @method Categoryarticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryarticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoryarticles::class);
    }

    //  * @return Categoryarticles[] Returns an array of Categoryarticles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categoryarticles
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllForWidget()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name')
            ->getQuery()
            ->getResult();
    }
}
