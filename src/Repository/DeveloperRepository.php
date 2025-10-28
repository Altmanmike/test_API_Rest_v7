<?php

namespace App\Repository;

use App\Dto\DtoListDevQuery;
use App\Entity\Developer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Developer>
 *  
 * @method Developer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Developer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Developer[]    findAll()
 * @method Developer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Developer::class);
    }

    /**
     * @return Developer[] Returns an array of Developer objects
     */
    public function findAllWithFilters(DtoListDevQuery $query): array
    {
        $qb = $this->createQueryBuilder('d');
        
        if($query->title) {
            $qb->andWhere('d.title LIKE :val');
            $qb->setParameter('val', "%$query->title%");
        }

        if($query->description) {
            $qb->andWhere('d.description LIKE :val');
            $qb->setParameter('val', "%$query->description%");
        }

        if($query->companies) {
            $qb->andWhere('d.companies = :val');
            $qb->setParameter('val', $query->companies);
        }

        if($query->experience) {
            $qb->andWhere('d.experience = :val');
            $qb->setParameter('val', $query->experience);
        }

        if(null !== $query->isParticipant) {
            $qb->andWhere('d.isParticipant = :val');
            $qb->setParameter('val', $query->isParticipant);
        }

        $offset = ($query->page - 1) * $query->itemsPerPage;

        $qb->setFirstResult($offset);
        $qb->setMaxResults($query->itemsPerPage);
                
        return $qb->getQuery()->getResult();        
    }
    
    /**
     * add
     *
     * @param  mixed $dev
     * @param  mixed $flush
     * @return void
     */
    public function add(Developer $dev, bool $flush = false): void
    {
        $this->getEntityManager()->persist($dev);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * remove
     *
     * @param  mixed $dev
     * @param  mixed $flush
     * @return void
     */
    public function remove(Developer $dev, bool $flush = false): void
    {
        $this->getEntityManager()->remove($dev);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * return Developer[] Returns an array of Developer objects
     */
    /*public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }/*
    
    /**
     * @return Developer[] Returns an array of Developer objects
     */
    /*public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/

}