<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Appartment::class, inversedBy="reservations")
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
        }

        return $this;
    }

    public function removeAppartment(Appartment $appartment): self
    {
        $this->appartments->removeElement($appartment);

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userReservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ID_User;

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
    private $totalPrice;
}
