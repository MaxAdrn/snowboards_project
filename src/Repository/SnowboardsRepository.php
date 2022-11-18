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

    public function orderByNom()
    {
       return $this->createQueryBuilder('s')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboards() {

       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsHomme()
    {
      return $this->createQueryBuilder('s')
      ->where('s.programme = 2')
      ->andWhere('s.genre = 1')
      ->groupBy('s.nom')
      ->getQuery()
       ->getResult()
      ;
    }

    public function findSplitboardsFemme()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.genre = 2')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsEnfant()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.genre = 3')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsCambreClassique()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.cambre = 1')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsCambreInverse()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.cambre = 2')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }
    
    public function findSplitboardsCambrePlat()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.cambre = 3')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsCambreW()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.cambre = 4')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsCambreRocker()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.cambre = 5')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsDebutant()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.niveau = 1')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsIntermediaire()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.niveau = 2')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsConfirme()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.niveau = 3')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsShapeTwin()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.shape = 1')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsShapeDirectionnel()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.shape = 2')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }

    public function findSplitboardsShapeTwinDir()
    {
       return $this->createQueryBuilder('s')
       ->where('s.programme = 2')
       ->andWhere('s.shape = 3')
       ->groupBy('s.nom')
       ->getQuery()
        ->getResult()
       ;
    }


//    public function findOneByIdJoinedToCategory(int $productId): ?Snowboards
//     {
//         $entityManager = $this->getEntityManager();

//         $query = $entityManager->createQuery(
//             'SELECT s, p
//             FROM App\Entity\Snowboards s
//             INNER JOIN s.programme p
//             WHERE p.nom = splitboard'
//         )->setParameter('id', $productId);

//         return $query->getOneOrNullResult();
//     }

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
