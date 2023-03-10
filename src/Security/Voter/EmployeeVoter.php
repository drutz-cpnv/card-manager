<?php

namespace App\Security\Voter;

use App\Entity\Employee;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EmployeeVoter extends Voter
{
    public const CARD_CREATE = 'CARD_CREATE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CARD_CREATE])
            && $subject instanceof Employee;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (!$subject instanceof Employee) {
            return false;
        }

        return match ($attribute) {
            self::CARD_CREATE => $this->canCreateCard($subject),
            default => false,
        };
    }

    private function canCreateCard(Employee $employee): bool
    {
        if(is_null($employee->getPicture())) return false;
        if(is_null($employee->getFirstname()) || is_null($employee->getLastname())) return false;
        return true;
    }
}
