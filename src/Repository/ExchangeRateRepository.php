<?php

namespace App\Repository;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExchangeRate>
 *
 * @method ExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeRate[]    findAll()
 * @method ExchangeRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    public function findRate(int $idFrom, int $idTo)
    {
        $sql = "
        SELECT currency_from_id, currency_to_id, rate 
        FROM exchange_rate 
        WHERE (currency_from_id = :idFrom OR currency_to_id = :idFrom) AND (currency_from_id = :idTo OR currency_to_id = :idTo);
        ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->executeQuery([
            'idFrom' => $idFrom,
            'idTo' => $idTo
        ])
            ->fetchAssociative();

        if(!$result) {
            return false;
        }

        if (($result['currency_from_id'] !== $idFrom) || ($result['currency_to_id'] !== $idTo)) {
            return 1 / (float)$result['rate'];
        }
        return $result['rate'];
    }

    public function findAllRates()
    {
        $sql = "
        SELECT
        (SELECT code FROM  currency WHERE currency.id = exchange_rate.currency_from_id) as currency_from,
        (SELECT code FROM  currency WHERE currency.id = exchange_rate.currency_to_id) as currency_to,
        rate, id
        FROM exchange_rate;                         
        ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }

//    /**
//     * @return ExchangeRate[] Returns an array of ExchangeRate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExchangeRate
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
