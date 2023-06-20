<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FruitGenusRepository;

#[ORM\Entity(repositoryClass: FruitGenusRepository::class)]
class FruitGenus extends BaseEntity
{
    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $slug;

    public function __construct(string $name)
    {
        parent::__construct();
        $this->setName($name);
        $this->setSlug();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(): self
    {
        $this->slug = trim(strtolower(str_replace(' ', '_', $this->getName())));

        return $this;
    }

    public function serialize(): array
    {
        return array_merge([
            'name' => $this->getName(),
            'slug' => $this->getSlug()
        ], parent::serialize());
    }
}
