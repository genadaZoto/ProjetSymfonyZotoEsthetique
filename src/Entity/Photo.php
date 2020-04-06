<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePhoto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePhoto(): ?\DateTimeInterface
    {
        return $this->datePhoto;
    }

    public function setDatePhoto(\DateTimeInterface $datePhoto): self
    {
        $this->datePhoto = $datePhoto;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLienImage()
    {
        return $this->lienImage;
    }

    public function setLienImage($lienImage)
    {
        $this->lienImage = $lienImage;

        return $this;
    }
}
