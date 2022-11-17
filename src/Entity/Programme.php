<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 */
class Programme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Snowboards::class, mappedBy="programme")
     */
    private $snowboards;

    public function __construct()
    {
        $this->snowboards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Snowboards>
     */
    public function getSnowboards(): Collection
    {
        return $this->snowboards;
    }

    public function addSnowboard(Snowboards $snowboard): self
    {
        if (!$this->snowboards->contains($snowboard)) {
            $this->snowboards[] = $snowboard;
            $snowboard->setProgramme($this);
        }

        return $this;
    }

    public function removeSnowboard(Snowboards $snowboard): self
    {
        if ($this->snowboards->removeElement($snowboard)) {
            // set the owning side to null (unless already changed)
            if ($snowboard->getProgramme() === $this) {
                $snowboard->setProgramme(null);
            }
        }

        return $this;
    }
}
