<?php

namespace App\Repository;

use App\Entity\FruitFamily;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<FruitFamily>
 *
 * @method FruitFamily|null find($id, $lockMode = null, $lockVersion = null)
 * @method FruitFamily|null findOneBy(array $criteria, array $orderBy = null)
 * @method FruitFamily[]    findAll()
 * @method FruitFamily[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitFamilyRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FruitFamily::class);
    }
}
