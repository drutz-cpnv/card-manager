<?php

namespace App\Data;

use App\Entity\Card;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PrintData
{

    /**
     * @var ArrayCollection<Card>|Collection<Card>
     */
    private Collection|ArrayCollection $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function addCard(Card $card): self
    {
        $this->cards->add($card);
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getCards(): ArrayCollection|Collection
    {
        return $this->cards;
    }

    /**
     * @param array<Card> $cards
     * @return PrintData
     */
    public function setCards(array $cards): PrintData
    {
        $this->cards = new ArrayCollection($cards);
        return $this;
    }



}