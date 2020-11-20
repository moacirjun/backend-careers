<?php

namespace App\Repository;

use App\Entity\Job;
use App\Entity\JobInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    /**
    * @return Job[] Returns an array of User objects
    */
    public function findAllVisible()
    {
        return $this->findAllVisibleAsQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findAllVisibleAsQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.status = :status')
            ->setParameter('status', JobInterface::STATUS_VISIBLE)
            ->orderBy('j.id', 'DESC')
        ;
    }

    /**
    * @return Job[] Returns an array of User objects
    */
    public function findLatestVisible()
    {
        return $this->findAllVisibleAsQueryBuilder()
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
