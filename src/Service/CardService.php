<?php

namespace App\Service;

use App\Entity\Card;
use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;

class CardService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function create(Employee $employee): Card
    {
        return Card::createFromEmployee($employee);
    }

}