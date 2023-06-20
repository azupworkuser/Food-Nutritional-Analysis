<?php

namespace App\Controller;

use App\Entity\BaseEntity;
use JetBrains\PhpStorm\ArrayShape;
use App\Interface\SerializableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController implements SerializableInterface
{
    final public function serialize(BaseEntity $entity): array
    {
        return $entity->serialize();
    }

    /**
     * @param $items
     * @return array
     */
    final public function serializeCollection($items): array
    {
        $response = [];
        foreach ($items as $item) {
            $response[] = $this->serialize($item);
        }

        return $response;
    }
}