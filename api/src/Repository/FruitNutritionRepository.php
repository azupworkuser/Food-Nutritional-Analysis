<?php

namespace App\Repository;

use App\Entity\FruitNutrition;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<FruitNutrition>
 *
 * @method FruitNutrition|null find($id, $lockMode = null, $lockVersion = null)
 * @method FruitNutrition|null findOneBy(array $criteria, array $orderBy = null)
 * @method FruitNutrition[]    findAll()
 * @method FruitNutrition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitNutritionRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FruitNutrition::class);
    }
}
