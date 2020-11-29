<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ServicePricing::class, mappedBy="ID_Service")
     */
    private $servicePricings;

    public function __construct()
    {
        $this->servicePricings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ServicePricing[]
     */
    public function getServicePricings(): Collection
    {
        return $this->servicePricings;
    }

    public function addServicePricing(ServicePricing $servicePricing): self
    {
        if (!$this->servicePricings->contains($servicePricing)) {
            $this->servicePricings[] = $servicePricing;
            $servicePricing->setIDService($this);
        }

        return $this;
    }

    public function removeServicePricing(ServicePricing $servicePricing): self
    {
        if ($this->servicePricings->removeElement($servicePricing)) {
            // set the owning side to null (unless already changed)
            if ($servicePricing->getIDService() === $this) {
                $servicePricing->setIDService(null);
            }
        }

        return $this;
    }
}
