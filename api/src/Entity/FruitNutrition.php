<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FruitNutritionRepository;

#[ORM\Entity(repositoryClass: FruitNutritionRepository::class)]
class FruitNutrition extends BaseEntity
{
    #[ORM\Column]
    private float $carbohydrates;

    #[ORM\Column]
    private float $protein;

    #[ORM\Column]
    private float $fat;

    #[ORM\Column]
    private float $calories;

    #[ORM\Column]
    private float $sugar;

    public function getCarbohydrates(): float
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getFat(): float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getCalories(): float
    {
        return $this->calories;
    }

    public function setCalories(float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getSugar(): float
    {
        return $this->sugar;
    }

    public function setSugar(float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function serialize(): array
    {
        return array_merge([
            'carbohydrates' => $this->getCarbohydrates(),
            'protein' => $this->getProtein(),
            'fat' => $this->getFat(),
            'calories' => $this->getCalories(),
            'sugar' => $this->getSugar()
        ], parent::serialize());
    }
}
