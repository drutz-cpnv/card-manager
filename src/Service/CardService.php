<?php

namespace App\Service;

use App\Entity\Card;
use App\Entity\Employee;
use App\Repository\CardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class CardService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CardRepository $cardRepository,
    )
    {
    }

    public function create(Employee $employee): Card
    {
        return $this->setToPrint(Card::createFromEmployee($employee));
    }

    private function setToPrint(Card $card): Card {
        $toPrintToday = new ArrayCollection($this->cardRepository->findToPrintToday());

        if(!$toPrintToday->isEmpty()) {
            $lastUid = (int)$toPrintToday->last()->getUid();
        }

        if(is_null($card->getUid()) || $card->getUid() === "") {
            if (!isset($lastUid)) {
                $card->setUid((new \DateTime())->format("Ymd") . "001");
            } else {
                $lastUid++;
                $card->setUid($lastUid);
            }
        }

        $card
            ->setToPrint(true);

        return $card;

    }

}