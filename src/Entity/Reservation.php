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
     * @return mixed
     */
    public function getIDUser()
    {
        return $this->ID_User;
    }

    /**
     * @param mixed $ID_User
     */
    public function setIDUser($ID_User): void
    {
        $this->ID_User = $ID_User;
    }


    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $totalPrice;

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }


}
