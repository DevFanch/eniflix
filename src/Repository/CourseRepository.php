<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * Renvoie les 5 derniers cours qui ont une dur e sup rieure  2
     * 
     * @return Course[]
     */
    public function findLastCourses(): array {
        // en DQL
        $entityManager = $this->getEntityManager();
        $dql = "SELECT c
            FROM App\Entity\Course c
            WHERE c.duration > 2
            ORDER BY c.createdAt DESC";
        $query = $entityManager->createQuery($dql);
        $query->setMaxResults(5);
        return $query->getResult();
    }

    // public function findLastCoursesO(): array {
    //     $query = $this->createQueryBuilder('c')
    //         ->addSelect('ca')
    //         ->addSelect('tr')
    //         ->leftJoin('c.category', 'ca')
    //         ->leftJoin('c.trainers', 'tr')
    //         ->orderBy('c.createdAt', 'DESC')
    //         // ->setMaxResults(5)
    //         ->getQuery();
    //     return $query->getResult();
    // }

    public function findLastCoursesO(): Paginator {
        $queryBuiler = $this->createQueryBuilder('c')
            ->addSelect('ca')
            ->addSelect('tr')
            ->leftJoin('c.category', 'ca')
            ->leftJoin('c.trainers', 'tr')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(5)
        ;
        $query = $queryBuiler->getQuery();
        return new Paginator($query);
    }

    public function findLastCoursesL(int $limit = 2): array {
        // en DQL
        $entityManager = $this->getEntityManager();
        $dql = "SELECT c
            FROM App\Entity\Course c
            WHERE c.duration > :limit
            ORDER BY c.createdAt DESC";
        $query = $entityManager->createQuery($dql);
        $query->setParameter('limit', $limit)
            ->setMaxResults(5);
        return $query->getResult();
    }
}
