<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrestationRepository")
 */
class Prestation
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
    private $datePrestation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $carteBancaire;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $prixService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="prestations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="prestations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePrestation(): ?\DateTimeInterface
    {
        return $this->datePrestation;
    }

    public function setDatePrestation(\DateTimeInterface $datePrestation): self
    {
        $this->datePrestation = $datePrestation;

        return $this;
    }

    public function getCarteBancaire(): ?bool
    {
        return $this->carteBancaire;
    }

    public function setCarteBancaire(bool $carteBancaire): self
    {
        $this->carteBancaire = $carteBancaire;

        return $this;
    }

    public function getPrixService(): ?string
    {
        return $this->prixService;
    }

    public function setPrixService(string $prixService): self
    {
        $this->prixService = $prixService;

        return $this;
    }

    public function getService(): ?service
    {
        return $this->service;
    }

    public function setService(?service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
