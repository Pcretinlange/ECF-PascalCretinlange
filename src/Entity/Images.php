<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $bin;

    #[ORM\ManyToMany(targetEntity: HotelRooms::class, mappedBy: 'Images')]
    private $hotelRooms;

    public function __construct()
    {
        $this->hotelRooms = new ArrayCollection();
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

    public function getBin()
    {
        return $this->bin;
    }

    public function setBin($bin): self
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * @return Collection<int, HotelRooms>
     */
    public function getHotelRooms(): Collection
    {
        return $this->hotelRooms;
    }

    public function addHotelRoom(HotelRooms $hotelRoom): self
    {
        if (!$this->hotelRooms->contains($hotelRoom)) {
            $this->hotelRooms[] = $hotelRoom;
            $hotelRoom->addImage($this);
        }

        return $this;
    }

    public function removeHotelRoom(HotelRooms $hotelRoom): self
    {
        if ($this->hotelRooms->removeElement($hotelRoom)) {
            $hotelRoom->removeImage($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->getName();
    }
}
