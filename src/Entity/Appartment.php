<?php

namespace App\Entity;

use App\Repository\AppartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AppartmentRepository::class)
 */
class Appartment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=5, nullable=false)
     */
    private $number;

    /**
     * @ORM\Column(type="smallint")
     */
    private $numberOfRooms;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Facility::class, inversedBy="appartments")
     */
    private $facilities;

    /**
     * @ORM\OneToMany(targetEntity=AppartmentPricing::class, mappedBy="ID_Appartment")
     */
    private $appartmentPricings;

    /**
     * @ORM\ManyToMany(targetEntity=Reservation::class, mappedBy="appartments")
     */
    private $reservations;

    public function __construct()
    {
        $this->facilities = new ArrayCollection();
        $this->appartmentPricings = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
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

    public function getNumberOfRooms(): ?int
    {
        return $this->numberOfRooms;
    }

    public function setNumberOfRooms(int $numberOfRooms): self
    {
        $this->numberOfRooms = $numberOfRooms;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Facility[]
     */
    public function getFacilities(): Collection
    {
        return $this->facilities;
    }

    /**
     * @param ArrayCollection $facilities
     */
    public function setFacilities(ArrayCollection $facilities): void
    {
        $this->facilities = $facilities;
    }

    public function addFacility(Facility $facility): self
    {
        if (!$this->facilities->contains($facility)) {
            $this->facilities[] = $facility;
        }

        return $this;
    }

    public function removeFacility(Facility $facility): self
    {
        $this->facilities->removeElement($facility);

        return $this;
    }

    /**
     * @return Collection|AppartmentPricing[]
     */
    public function getAppartmentPricings(): Collection
    {
        return $this->appartmentPricings;
    }

    /**
     * @return AppartmentPricing
     */
    public function getCurrentAppartmentPricing(): AppartmentPricing
    {

        $currentPricing = array_filter($this->appartmentPricings->getValues(), function ($v) {
            return $v->getStartDate() <= new \DateTime() && $v->getEndDate() >= new \DateTime();
        });

        if ($currentPricing && count($currentPricing) > 0) {
            return $currentPricing[0];
        }
        return new AppartmentPricing();

    }

    /**
     * @param ArrayCollection $appartmentPricings
     */
    public function setAppartmentPricings(ArrayCollection $appartmentPricings): void
    {
        $this->appartmentPricings = $appartmentPricings;
    }

    public function addAppartmentPricing(AppartmentPricing $appartmentPricing): self
    {
        if (!$this->appartmentPricings->contains($appartmentPricing)) {
            $this->appartmentPricings[] = $appartmentPricing;
            $appartmentPricing->setIDAppartment($this);
        }

        return $this;
    }

    public function removeAppartmentPricing(AppartmentPricing $appartmentPricing): self
    {
        if ($this->appartmentPricings->removeElement($appartmentPricing)) {
            // set the owning side to null (unless already changed)
            if ($appartmentPricing->getIDAppartment() === $this) {
                $appartmentPricing->setIDAppartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    /**
     * @param ArrayCollection $reservations
     */
    public function setReservations(ArrayCollection $reservations): void
    {
        $this->reservations = $reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->addAppartment($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeAppartment($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->number;
    }
}
