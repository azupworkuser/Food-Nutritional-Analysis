<?php

namespace App\Interface;

use App\Entity\BaseEntity;

interface SerializableInterface
{
    public function serialize(BaseEntity $entity): array;
    public function serializeCollection($items): array;
}