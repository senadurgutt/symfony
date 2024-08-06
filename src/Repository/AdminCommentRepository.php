<?php

namespace App\Repository;

use App\Entity\AdminComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdminComment>
 *
 * @method AdminComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminComment[]    findAll()
 * @method AdminComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminComment::class);
    }

    public function add(AdminComment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdminComment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
