<?php

namespace App\Repository;

use App\Entity\Fruit;
use App\Entity\FruitFamily;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    /**
     * @param string|null $query
     * @param FruitFamily|null $family
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function getFruitListByFilter(?string $query, ?FruitFamily $family, int $page, int $limit): Paginator
    {
        $qb = $this->createQueryBuilder('fruit');
        if (!empty($query)) {
            $qb->andWhere('fruit.name LIKE :query')->setParameter('query', "%{$query}%");
        }

        if (!empty($family)) {
            $qb->andWhere('fruit.family = :family')->setParameter('family', $family->getUuid()->toBinary());
        }

        return $this->paginate($qb->getQuery(), $page, $limit);
    }

    /**
     * @return bool
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isMaxFavoriteReached(): bool
    {
        $response = $this->createQueryBuilder('fruit')
            ->select('COUNT(fruit.uuid)')
            ->andWhere('fruit.isFavorite = :favorite')
            ->setParameter('favorite', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();

        return $response > Fruit::MAX_FAVORITE;
    }
}
