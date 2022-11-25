<?php

namespace App\Entity;

use App\Repository\SnowboardsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=SnowboardsRepository::class)
 * @Vich\Uploadable
 */
class Snowboards
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Cambre::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cambre;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Programme::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $programme;

    /**
     * @ORM\ManyToOne(targetEntity=Shape::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shape;

    /**
     * @ORM\ManyToOne(targetEntity=Snowinsert::class, inversedBy="snowboards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $snowinsert;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * @Vich\UploadableField(mapping="snowboards", fileNameProperty="imageName")
     * @var File|null
     */
    private $imageFile;

     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $imageName;   


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getCambre(): ?Cambre
    {
        return $this->cambre;
    }

    public function setCambre(?Cambre $cambre): self
    {
        $this->cambre = $cambre;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getShape(): ?Shape
    {
        return $this->shape;
    }

    public function setShape(?Shape $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getSnowinsert(): ?Snowinsert
    {
        return $this->snowinsert;
    }

    public function setSnowinsert(?Snowinsert $snowinsert): self
    {
        $this->snowinsert = $snowinsert;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

}
