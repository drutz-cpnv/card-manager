<?php

namespace App\Entity;

use App\Data\PrintData;
use App\Repository\PrintRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrintRequestRepository::class)]
class PrintRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $printed_at = null;

    #[ORM\OneToMany(mappedBy: 'printRequest', targetEntity: Card::class)]
    private Collection $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public static function fromData(PrintData $data): PrintRequest
    {
        return (new PrintRequest())
            ->addCards($data->getCards())
            ;
    }

    public function getData(): PrintData
    {
        return (new PrintData())
            ->setCards($this->getCards()->toArray());
    }

    public function updateFromData(PrintData $data): self
    {
        foreach ($this->getCards() as $card) {
            $this->removeCard($card);
        }
        $this->addCards($data->getCards());
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPrintedAt(): ?\DateTimeImmutable
    {
        return $this->printed_at;
    }

    public function setPrintedAt(?\DateTimeImmutable $printed_at): self
    {
        $this->printed_at = $printed_at;

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setPrintRequest($this);
        }

        return $this;
    }

    public function addCards(array|Collection $cards): self
    {
        foreach ($cards as $card) {
            $this->addCard($card);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getPrintRequest() === $this) {
                $card->setPrintRequest(null);
            }
        }

        return $this;
    }

    public function printed(): self
    {
        $this->setPrintedAt(new \DateTimeImmutable());
        return $this;
    }

    public function isPrinted(): bool
    {
        return !is_null($this->getPrintedAt());
    }
}
