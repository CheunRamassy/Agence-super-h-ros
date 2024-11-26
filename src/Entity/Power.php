<?php

namespace App\Entity;

use App\Repository\PowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PowerRepository::class)]
class Power
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\JoinColumn(nullable: true)]
    #[ORM\OneToOne(inversedBy: 'powerHero',  cascade: ['persist', 'remove'])]
    private ?SuperHeros $powerHero = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getPowerHero(): ?SuperHeros
    {
        return $this->powerHero;
    }

    public function setPowerHero(?SuperHeros $powerHero): static
    {
        $this->powerHero = $powerHero;

        return $this;
    }

   
}
