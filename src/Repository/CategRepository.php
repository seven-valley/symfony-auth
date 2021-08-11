<?php

namespace App\Repository;

use App\Entity\Categ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categ|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categ|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categ[]    findAll()
 * @method Categ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categ::class);
    }

    public function findByPublished()
    {

        return $this->createQueryBuilder('c') // c pour Entity Categ
            // je souhaite faire un join sur l'entity Wish
            ->addSelect('w')
            // comment je relie Categ à wish
            ->join('c.wishes', 'w')
            ->where('w.isPublished = true') // je prend que les wishes publié
            ->orderBy('w.dateCreated', 'DESC') // je classe par odre de crea
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Categ[] Returns an array of Categ objects
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
    public function findOneBySomeField($value): ?Categ
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
