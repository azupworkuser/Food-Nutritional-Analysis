<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FruitRepository;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit extends BaseEntity
{
    public const MAX_FAVORITE = 10;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $fruitId;

    #[ORM\Column]
    private bool $isFavorite = false;

    #[ORM\ManyToOne(targetEntity: FruitFamily::class)]
    #[ORM\JoinColumn(name: "family_uuid", referencedColumnName: "uuid", nullable: false)]
    private FruitFamily $family;

    #[ORM\ManyToOne(targetEntity: FruitGenus::class)]
    #[ORM\JoinColumn(name: "genus_uuid", referencedColumnName: "uuid", nullable: false)]
    private FruitGenus $genus;

    #[ORM\ManyToOne(targetEntity: FruitOrder::class)]
    #[ORM\JoinColumn(name: "order_uuid", referencedColumnName: "uuid", nullable: false)]
    private FruitOrder $fruitOrder;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "nutrition_uuid", referencedColumnName: "uuid", nullable: false)]
    private FruitNutrition $nutrition;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFruitId(): int
    {
        return $this->fruitId;
    }

    public function setFruitId(int $fruitId): self
    {
        $this->fruitId = $fruitId;

        return $this;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }

    public function getFamily(): FruitFamily
    {
        return $this->family;
    }

    public function setFamily(FruitFamily $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getGenus(): FruitGenus
    {
        return $this->genus;
    }

    public function setGenus(FruitGenus $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getOrder(): FruitOrder
    {
        return $this->fruitOrder;
    }

    public function setOrder(FruitOrder $order): self
    {
        $this->fruitOrder = $order;

        return $this;
    }

    public function getNutrition(): ?FruitNutrition
    {
        return $this->nutrition;
    }

    public function setNutrition(FruitNutrition $nutrition): self
    {
        $this->nutrition = $nutrition;

        return $this;
    }

    public function serialize(): array
    {
        return array_merge([
            'name' => $this->getName(),
            'is_favorite' => $this->getIsFavorite(),
            'family' => $this->getFamily()->serialize(),
            'genus' => $this->getGenus()->serialize(),
            'order' => $this->getOrder()->serialize(),
            'nutrition' => $this->getNutrition()->serialize()
        ], parent::serialize());
    }
}
