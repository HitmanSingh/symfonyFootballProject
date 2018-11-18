<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClubTeamRepository")
 * @UniqueEntity(
 *     fields={"club", "team"},
 *     errorPath="team",
 *     message="This team is already in use on that club."
 * )
 */

class ClubTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $year_creation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="clubTeams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="clubTeams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="club")
     */
    private $articles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stadium", inversedBy="clubTeams")
     */
    private $stadium;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getYearCreation(): ?int
    {
        return $this->year_creation;
    }

    public function setYearCreation(int $year_creation): self
    {
        $this->year_creation = $year_creation;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addClub($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            $article->removeClub($this);
        }

        return $this;
    }

    public function getStadium(): ?Stadium
    {
        return $this->stadium;
    }

    public function setStadium(?Stadium $stadium): self
    {
        $this->stadium = $stadium;

        return $this;
    }
}
