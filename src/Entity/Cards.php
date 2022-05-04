<?php

namespace App\Entity;

use App\Repository\CardsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardsRepository::class)]
class Cards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\Column(type: 'integer')]
    private $value;

    #[ORM\Column(type: 'string', length: 255,  nullable: true)]
    private $image;

    #[ORM\Column(type: 'datetime_immutable')]
    private $buyAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $sellAt;

    #[ORM\Column(type: 'boolean')]
    private $inSell;

    #[ORM\Column(type: 'text')]
    private $description;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBuyAt(): ?\DateTimeImmutable
    {
        return $this->buyAt;
    }

    public function setBuyAt(\DateTimeImmutable $buyAt): self
    {
        $this->buyAt = $buyAt;

        return $this;
    }

    public function getSellAt(): ?\DateTimeImmutable
    {
        return $this->sellAt;
    }

    public function setSellAt(\DateTimeImmutable $sellAt): self
    {
        $this->sellAt = $sellAt;

        return $this;
    }

    public function getInSell(): ?bool
    {
        return $this->inSell;
    }

    public function setInSell(bool $inSell): self
    {
        $this->inSell = $inSell;

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
}
