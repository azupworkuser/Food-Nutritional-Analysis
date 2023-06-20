<?php

namespace App\Repository;

use App\Entity\FruitGenus;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<FruitGenus>
 *
 * @method FruitGenus|null find($id, $lockMode = null, $lockVersion = null)
 * @method FruitGenus|null findOneBy(array $criteria, array $orderBy = null)
 * @method FruitGenus[]    findAll()
 * @method FruitGenus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitGenusRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FruitGenus::class);
    }
}
