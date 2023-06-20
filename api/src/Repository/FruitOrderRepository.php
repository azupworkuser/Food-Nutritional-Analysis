<?php

namespace App\Repository;

use App\Entity\FruitOrder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<FruitOrder>
 *
 * @method FruitOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method FruitOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method FruitOrder[]    findAll()
 * @method FruitOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitOrderRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FruitOrder::class);
    }
}
