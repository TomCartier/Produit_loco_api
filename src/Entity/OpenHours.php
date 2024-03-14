<?php

namespace App\Entity;

use App\Repository\OpenHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpenHoursRepository::class)]
class OpenHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_am = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_am = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_pm = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_pm = null;

    #[ORM\ManyToOne(inversedBy: 'open_hours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Farm $farm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getStartAm(): ?\DateTimeInterface
    {
        return $this->start_am;
    }

    public function setStartAm(?\DateTimeInterface $start_am): static
    {
        $this->start_am = $start_am;

        return $this;
    }

    public function getEndAm(): ?\DateTimeInterface
    {
        return $this->end_am;
    }

    public function setEndAm(?\DateTimeInterface $end_am): static
    {
        $this->end_am = $end_am;

        return $this;
    }

    public function getStartPm(): ?\DateTimeInterface
    {
        return $this->start_pm;
    }

    public function setStartPm(?\DateTimeInterface $start_pm): static
    {
        $this->start_pm = $start_pm;

        return $this;
    }

    public function getEndPm(): ?\DateTimeInterface
    {
        return $this->end_pm;
    }

    public function setEndPm(?\DateTimeInterface $end_pm): static
    {
        $this->end_pm = $end_pm;

        return $this;
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function setFarm(?Farm $farm): static
    {
        $this->farm = $farm;

        return $this;
    }
}
