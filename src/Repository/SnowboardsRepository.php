<?php

namespace App\Repository;

use App\Entity\Snowboards;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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

   /**
    * Fonction pour la recherche personnalisée
    * @return Snowboards[] Returns an array of Snowboards objects
    */
   public function recherchePerso($criteres): array
   {
      return $this->createQueryBuilder('s')
         ->where('s.programme = :programme')
         ->setParameter('programme', $criteres->getProgramme()->getId())
         ->andwhere('s.shape = :shape')
         ->setParameter('shape', $criteres->getShape()->getId())
         ->andwhere('s.genre = :genre')
         ->setParameter('genre', $criteres->getGenre()->getId())
         ->andwhere('s.cambre = :cambre')
         ->setParameter('cambre', $criteres->getCambre()->getId())
         ->andwhere('s.marque = :marque')
         ->setParameter('marque', $criteres->getMarque()->getId())
         ->andwhere('s.niveau = :niveau')
         ->setParameter('niveau', $criteres->getNiveau()->getId())
         ->andwhere('s.snowinsert = :snowinsert')
         ->setParameter('snowinsert', $criteres->getSnowinsert()->getId())
         ->groupBy('s.nom')
         ->getQuery()
         ->getResult()
      ;
   }
   
   //Fonction filtre pour tout les snowboards par nom pour pas de doublon
   public function orderByNom()
   {
      return $this->createQueryBuilder('s')
      ->groupBy('s.nom')
      ->getQuery()
      ->getResult()
      ;
   }
   
   public function findByProgramme(int $programme) : array {
      $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\Snowboards s
            WHERE s.programme = :programme'
        )->setParameter('programme', $programme);

        return $query->getResult();
   }
}
