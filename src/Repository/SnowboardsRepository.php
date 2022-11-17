<?php

namespace App\Repository;

use App\Entity\Snowboards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Snowboards>
 *
 * @method Snowboards|null find($id, $lockMode = null, $lockVersion = null)
 * @method Snowboards|null findOneBy(array $criteria, array $orderBy = null)
 * @method Snowboards[]    findAll()
 * @method Snowboards[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnowboardsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Snowboards::class);
    }

    public function add(Snowboards $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Snowboards $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function orderByNom(): array
   {
       return $this->createQueryBuilder('s')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
   }

//    /**
//     * @return Snowboards[] Returns an array of Snowboards objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Snowboards
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
