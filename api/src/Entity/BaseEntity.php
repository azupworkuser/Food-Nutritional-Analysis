<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

abstract class BaseEntity
{
    const DATE_FORMAT = "d F Y, h:i A";

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    protected UUid $uuid;

    #[ORM\Column]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column]
    protected \DateTimeImmutable $updatedAt;

    /**
     * BaseEntity Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return $this
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    #[ArrayShape(['uuid' => "string" ,'created_at' => "string" ,'updated_at' => "string"])]
    public function serialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'created_at' => $this->getCreatedAt()->format(self::DATE_FORMAT),
            'updated_at' => $this->getUpdatedAt()->format(self::DATE_FORMAT)
        ];
    }
}
