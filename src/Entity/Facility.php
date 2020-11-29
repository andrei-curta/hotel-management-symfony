<?php

namespace App\Entity;

use App\Repository\FacilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacilityRepository::class)
 */
class Facility
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Appartment::class, mappedBy="facilities")
     */
    private $appartments;

    public function __construct()
    {
        $this->appartments = new ArrayCollection();
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
     * @return Collection|Appartment[]
     */
    public function getAppartments(): Collection
    {
        return $this->appartments;
    }

    public function addAppartment(Appartment $appartment): self
    {
        if (!$this->appartments->contains($appartment)) {
            $this->appartments[] = $appartment;
            $appartment->addFacility($this);
        }

        return $this;
    }

    public function removeAppartment(Appartment $appartment): self
    {
        if ($this->appartments->removeElement($appartment)) {
            $appartment->removeFacility($this);
        }

        return $this;
    }
}
