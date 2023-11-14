<?php

namespace App\SubsistenceAllowance\Infrastructure\Repository;

use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use App\SubsistenceAllowance\Domain\Repository\BusinessTripRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BusinessTrip>
 *
 * @method BusinessTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusinessTrip[]    findAll()
 * @method BusinessTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessTripRepository extends ServiceEntityRepository implements BusinessTripRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessTrip::class);
    }

    public function persist(BusinessTrip $businessTrip): void
    {
        $this->getEntityManager()->persist($businessTrip);
        $this->getEntityManager()->flush();
    }

    /**
     * @return BusinessTrip[]
     */
    public function findByEmployee(EmployeeId $employeeId): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.employeeId = :employeeId')
            ->setParameter('employeeId', $employeeId)
            ->getQuery()
            ->getResult();
    }

    public function isExistsForUserBetweenStartAndEnd(
        EmployeeId $employeeId,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end
    ): bool {
        return (bool) $this->createQueryBuilder('e')
            ->select('COUNT(e.businessTripId)')
            ->andWhere('e.employeeId = :employeeId')
            ->andWhere(':start BETWEEN e.start AND e.end OR :end BETWEEN e.start AND e.end')
            ->setParameters(
                [
                    'employeeId' => $employeeId,
                    'start' => $start,
                    'end' => $end,
                ]
            )
            ->getQuery()
            ->getSingleScalarResult();
    }
}
