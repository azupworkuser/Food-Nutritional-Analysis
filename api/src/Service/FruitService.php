<?php

namespace App\Service;

use App\Entity\Fruit;
use GuzzleHttp\Client;
use App\Entity\BaseEntity;
use App\Entity\FruitGenus;
use App\Entity\FruitOrder;
use App\Entity\FruitFamily;
use App\Entity\FruitNutrition;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Exception\GuzzleException;
use App\Repository\FruitNutritionRepository;

class FruitService
{
    const BASE_URL = "https://fruityvice.com";
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function fetchFruits(): array
    {
        $client = $this->getClient();
        try {
            $response = $client->get('/api/fruit/all');
            $fruits = json_decode($response->getBody()->getContents(), true);
            return [true, $fruits];
        } catch (GuzzleException $exception) {
            return [false, $exception->getMessage()];
        }
    }

    public function handleFruitDepends(string $type, string $name): BaseEntity
    {
        $class = $this->getFruitEntityClass($type);
        $object = new $class($name);

        $repository = $this->manager->getRepository($class);
        $isExist = $repository->findOneBy(['slug' => $object->getSlug()]);
        if (!empty($isExist)) {
            return $isExist;
        }

        $repository->save($object, true);
        return $object;
    }

    public function handleFruitNutrition(array $nutritions): FruitNutrition
    {
        $nutrition = new FruitNutrition();
        $nutrition->setCarbohydrates($nutritions['carbohydrates'] ?? 0.00);
        $nutrition->setProtein($nutritions['protein'] ?? 0.00);
        $nutrition->setFat($nutritions['fat'] ?? 0.00);
        $nutrition->setCalories($nutritions['calories'] ?? 0.00);
        $nutrition->setSugar($nutritions['sugar'] ?? 0.00);

        /** @var FruitNutritionRepository $repository */
        $repository = $this->manager->getRepository(FruitNutrition::class);
        $repository->save($nutrition, true);

        return $nutrition;
    }

    public function handleFruitEntity(array $fruit): bool
    {
        /** @var FruitRepository $repository */
        $repository = $this->manager->getRepository(Fruit::class);
        $entity = $repository->findOneBy(['fruitId' => $fruit['id']]);
        $created = false;
        if (empty($entity)) {
            $entity = new Fruit();
            $created = true;
        }

        $entity->setName($fruit['name']);
        $entity->setFruitId($fruit['id']);
        $entity->setFamily($fruit['family']);
        $entity->setGenus($fruit['genus']);
        $entity->setOrder($fruit['order']);
        $entity->setNutrition($fruit['nutrition']);

        /** @var FruitRepository $repository */
        $repository = $this->manager->getRepository(Fruit::class);
        $repository->save($entity, true);
        return $created;
    }


    private function getFruitEntityClass(string $type): string
    {
        return match ($type) {
            'family' => FruitFamily::class,
            'genus' => FruitGenus::class,
            default => FruitOrder::class,
        };
    }

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        return new Client([
            'base_uri' => self::BASE_URL
        ]);
    }
}
