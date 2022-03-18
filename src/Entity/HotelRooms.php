<?php

namespace App\Entity;

use App\Repository\HotelRoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRoomsRepository::class)]
class HotelRooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'decimal', precision: 6, scale: 2)]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $booking_link;

    #[ORM\ManyToMany(targetEntity: Images::class, inversedBy: 'hotelRooms')]
    private $Images;

    #[ORM\OneToMany(mappedBy: 'hotelRooms', targetEntity: ReservationRooms::class)]
    private $Reservation_rooms;

    #[ORM\ManyToOne(targetEntity: Hotels::class, inversedBy: 'Hotel_rooms')]
    #[ORM\JoinColumn(nullable: false)]
    private $hotels;

    public function __construct()
    {
        $this->Images = new ArrayCollection();
        $this->Reservation_rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBookingLink(): ?string
    {
        return $this->booking_link;
    }

    public function setBookingLink(string $booking_link): self
    {
        $this->booking_link = $booking_link;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->Images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->Images->contains($image)) {
            $this->Images[] = $image;
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        $this->Images->removeElement($image);

        return $this;
    }

    /**
     * @return Collection<int, ReservationRooms>
     */
    public function getReservationRooms(): Collection
    {
        return $this->Reservation_rooms;
    }

    public function addReservationRoom(ReservationRooms $reservationRoom): self
    {
        if (!$this->Reservation_rooms->contains($reservationRoom)) {
            $this->Reservation_rooms[] = $reservationRoom;
            $reservationRoom->setHotelRooms($this);
        }

        return $this;
    }

    public function removeReservationRoom(ReservationRooms $reservationRoom): self
    {
        if ($this->Reservation_rooms->removeElement($reservationRoom)) {
            // set the owning side to null (unless already changed)
            if ($reservationRoom->getHotelRooms() === $this) {
                $reservationRoom->setHotelRooms(null);
            }
        }

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
}
