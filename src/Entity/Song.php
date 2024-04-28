<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\Type('integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 150,
        minMessage: "La cançó ha de tindre més de 3 lletres",
        maxMessage: "La cançó no pot tindre més de 150 lletres."
    )]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\Range(
        notInRangeMessage: "La duració ha d'estar entre 20 i 600 min.",
        min: 20,
        max: 600,
    )]
    #[Assert\Type('integer')]
    private ?int $duration = null;


    #[ORM\ManyToOne(inversedBy: 'songs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return ["id" => $this->getId(),
            "title"=> $this->getTitle(),
            "duration" => $this->getDuration(),
            "album" => $this->getAlbum()];
    }
}
