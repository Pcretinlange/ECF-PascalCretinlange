<?php

namespace App\Entity;

use App\Repository\HotelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelsRepository::class)]
class Hotels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'string', length: 50)]
    private $adress;

    #[ORM\Column(type: 'string', length: 50)]
    private $city;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'hotels')]
    private $Users;

    #[ORM\OneToMany(mappedBy: 'hotels', targetEntity: ReservationRooms::class)]
    private $Reservation_Rooms;

    #[ORM\OneToMany(mappedBy: 'hotels', targetEntity: HotelRooms::class)]
    private $Hotel_rooms;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
        $this->Reservation_Rooms = new ArrayCollection();
        $this->Hotel_rooms = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        $this->Users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, ReservationRooms>
     */
    public function getReservationRooms(): Collection
    {
        return $this->Reservation_Rooms;
    }

    public function addReservationRoom(ReservationRooms $reservationRoom): self
    {
        if (!$this->Reservation_Rooms->contains($reservationRoom)) {
            $this->Reservation_Rooms[] = $reservationRoom;
            $reservationRoom->setHotels($this);
        }

        return $this;
    }

    public function removeReservationRoom(ReservationRooms $reservationRoom): self
    {
        if ($this->Reservation_Rooms->removeElement($reservationRoom)) {
            // set the owning side to null (unless already changed)
            if ($reservationRoom->getHotels() === $this) {
                $reservationRoom->setHotels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HotelRooms>
     */
    public function getHotelRooms(): Collection
    {
        return $this->Hotel_rooms;
    }

    public function addHotelRoom(HotelRooms $hotelRoom): self
    {
        if (!$this->Hotel_rooms->contains($hotelRoom)) {
            $this->Hotel_rooms[] = $hotelRoom;
            $hotelRoom->setHotels($this);
        }

        return $this;
    }

    public function removeHotelRoom(HotelRooms $hotelRoom): self
    {
        if ($this->Hotel_rooms->removeElement($hotelRoom)) {
            // set the owning side to null (unless already changed)
            if ($hotelRoom->getHotels() === $this) {
                $hotelRoom->setHotels(null);
            }
        }

        return $this;
    }
}
