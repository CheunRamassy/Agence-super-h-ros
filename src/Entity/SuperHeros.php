<?php

namespace App\Entity;

use App\Repository\SuperHerosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SuperHerosRepository::class)]
#[Vich\Uploadable()]
class SuperHeros
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alterEgo = null;

    #[ORM\Column]
    private ?bool $available = null;

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 100)]
    private ?int $energyLevel = null;

    #[ORM\Column]
    private ?array $reussite = null;

    #[ORM\Column(length: 255)]
    private ?string $biography = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'heros', fileNameProperty: 'imageName')]
    #[Assert\Image()]
    private ?File $imageNameFile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'leader')]
    private Collection $teams;

    /**
     * @var Collection<int, Team>
     */
    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'members')]
    private Collection $teamsMembers;

    // #[ORM\Column(nullable: false)]
    #[ORM\OneToOne(mappedBy: 'powerHero', cascade: ['persist', 'remove'])]
    private ?Power $powerHero = null;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->teamsMembers = new ArrayCollection();
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

    public function getAlterEgo(): ?string
    {
        return $this->alterEgo;
    }

    public function setAlterEgo(?string $alterEgo): static
    {
        $this->alterEgo = $alterEgo;

        return $this;
    }

    public function Available(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }

    public function getEnergyLevel(): ?int
    {
        return $this->energyLevel;
    }

    public function setEnergyLevel(int $energyLevel): static
    {
        $this->energyLevel = $energyLevel;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageNameFile(): ?File
    {
        return $this->imageNameFile;
    }

    public function setImageNameFile(?File $imageNameFile): static
    {
        $this->imageNameFile = $imageNameFile;

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

    public function getReussite(): ?Array
    {
        return $this->reussite;
    }

    public function setReussite(?Array $reussite): static
    {
        $this->reussite = $reussite;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setLeader($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getLeader() === $this) {
                $team->setLeader(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeamsMembers(): Collection
    {
        return $this->teamsMembers;
    }

    public function addTeamsMember(Team $teamsMember): static
    {
        if (!$this->teamsMembers->contains($teamsMember)) {
            $this->teamsMembers->add($teamsMember);
            $teamsMember->addMember($this);
        }

        return $this;
    }

    public function removeTeamsMember(Team $teamsMember): static
    {
        if ($this->teamsMembers->removeElement($teamsMember)) {
            $teamsMember->removeMember($this);
        }

        return $this;
    }

    public function getPowerHero(): ?Power
    {
        return $this->powerHero;
    }

    public function setPowerHero(?Power $powerHero): static
    {
        // unset the owning side of the relation if necessary
        if ($powerHero === null && $this->powerHero !== null) {
            $this->powerHero->setPowerHero(null);
        }

        // set the owning side of the relation if necessary
        if ($powerHero !== null && $powerHero->getPowerHero() !== $this) {
            $powerHero->setPowerHero($this);
        }

        $this->powerHero = $powerHero;

        return $this;
    }

    public function __toString()
    {
        return $this->getReussite();
    }


}
