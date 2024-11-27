<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Mission $currentMission = null;

    /**
     * @var Collection<int, Mission>
     */
    #[ORM\OneToMany(targetEntity: Mission::class, mappedBy: 'assignedTeam')]
    private Collection $missions;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    // #[Assert\Length(min: 80, max: 100)]
    private ?SuperHeros $leader = null;

    /**
     * @var Collection<int, SuperHeros>
     */
    #[ORM\ManyToMany(targetEntity: SuperHeros::class, inversedBy: 'teamsMembers')]
    #[Assert\Range(min: 2, max: 5)]
    private Collection $members;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
        $this->members = new ArrayCollection();

    }

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

    public function active(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCurrentMission(): ?Mission
    {
        return $this->currentMission;
    }

    public function setCurrentMission(?Mission $currentMission): static
    {
        $this->currentMission = $currentMission;

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): static
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setAssignedTeam($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getAssignedTeam() === $this) {
                $mission->setAssignedTeam(null);
            }
        }

        return $this;
    }

    public function getLeader(): ?SuperHeros
    {
        return $this->leader;
    }

    public function setLeader(?SuperHeros $leader): static
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Collection<int, SuperHeros>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(SuperHeros $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(SuperHeros $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }


}
