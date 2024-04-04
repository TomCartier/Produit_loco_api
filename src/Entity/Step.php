<?php

namespace App\Entity;

use App\Repository\StepRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: StepRepository::class)]
#[Broadcast]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateStepStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateStepStop = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateCanceled = null;

    #[ORM\OneToOne(inversedBy: 'step', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'steps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StepList $listStep = null;

    #[ORM\OneToOne(mappedBy: 'step', cascade: ['persist', 'remove'])]
    private ?Order $orderStep = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStepStart(): ?\DateTimeInterface
    {
        return $this->DateStepStart;
    }

    public function setDateStepStart(?\DateTimeInterface $DateStepStart): static
    {
        $this->DateStepStart = $DateStepStart;

        return $this;
    }

    public function getDateStepStop(): ?\DateTimeInterface
    {
        return $this->DateStepStop;
    }

    public function setDateStepStop(?\DateTimeInterface $DateStepStop): static
    {
        $this->DateStepStop = $DateStepStop;

        return $this;
    }

    public function getDateCanceled(): ?\DateTimeInterface
    {
        return $this->DateCanceled;
    }

    public function setDateCanceled(?\DateTimeInterface $DateCanceled): static
    {
        $this->DateCanceled = $DateCanceled;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getListStep(): ?StepList
    {
        return $this->listStep;
    }

    public function setListStep(?StepList $listStep): static
    {
        $this->listStep = $listStep;

        return $this;
    }

    public function getOrderStep(): ?Order
    {
        return $this->orderStep;
    }

    public function setOrderStep(Order $orderStep): static
    {
        // set the owning side of the relation if necessary
        if ($orderStep->getStep() !== $this) {
            $orderStep->setStep($this);
        }

        $this->orderStep = $orderStep;

        return $this;
    }
}
