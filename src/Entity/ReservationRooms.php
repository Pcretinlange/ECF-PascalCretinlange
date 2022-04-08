<?php

namespace App\Entity;

use App\Repository\ReservationRoomsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRoomsRepository::class)]
class ReservationRooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $start_date;

    #[ORM\Column(type: 'date')]
    private $end_date;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'Reservation_rooms')]
    private $users;

    #[ORM\ManyToOne(targetEntity: Hotels::class, inversedBy: 'Reservation_Rooms')]
    private $hotels;

    #[ORM\ManyToOne(targetEntity: HotelRooms::class, inversedBy: 'Reservation_rooms')]
    private $hotelRooms;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private $totalPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getHotels(): ?Hotels
    {
        return $this->hotels;
    }

    public function setHotels(?Hotels $hotels): self
    {
        $this->hotels = $hotels;

        return $this;
    }

    public function getHotelRooms(): ?HotelRooms
    {
        return $this->hotelRooms;
    }

    public function setHotelRooms(?HotelRooms $hotelRooms): self
    {
        $this->hotelRooms = $hotelRooms;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }
}
