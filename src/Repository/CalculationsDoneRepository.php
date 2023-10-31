<?php

namespace App\Repository;

use App\Entity\CalculationsDone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalculationsDone>
 *
 * @method CalculationsDone|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalculationsDone|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalculationsDone[]    findAll()
 * @method CalculationsDone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculationsDoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalculationsDone::class);
    }

    public function deleteHistory()
    {
        $sql = "TRUNCATE TABLE calculations_done;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql)->executeQuery();
    }

//    /**
//     * @return CalculationsDone[] Returns an array of CalculationsDone objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CalculationsDone
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
