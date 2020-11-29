<?php

namespace App\Entity;

use App\Repository\AppartmentPricingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppartmentPricingRepository::class)
 */
class AppartmentPricing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Appartment::class, inversedBy="appartmentPricings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ID_Appartment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDAppartment(): ?Appartment
    {
        return $this->ID_Appartment;
    }

    public function setIDAppartment(?Appartment $ID_Appartment): self
    {
        $this->ID_Appartment = $ID_Appartment;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
