<?php

namespace App\Service;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Sabre\VObject\Component\VCard;
use Sabre\VObject\Document;

class VirtualCardService
{

    public function __construct(
        private EmployeeRepository $employeeRepository,
    )
    {}

    /**
     * Retourne un tableau avec comme clé `v_card`: `VCard::class` et `string`: `string`
     * @param Employee $employee
     * @return VCard
     */
    public function create(Employee $employee): VCard
    {
        $vcard = new VCard([
            'CLASS' => 'CONFIDENTIAL',
            'KIND'  => 'individual',
            'CATEGORIES' => [
                'Police'
            ],
            'FN'    => (string)$employee,
            'N'     => [
                $employee->getLastname(),
                $employee->getFirstname(),
                '',
                $employee->getRankAbbreviation()
            ],
            'ORG'   => [
                'Police Région Morges',
            ],
            'ROLE'  => $employee->getRoleValue(),
            'TITLE' => $employee->isIsPolice() ? $employee->getRankValue() : $employee->getRoleValue(),
        ]);

        $vcard->add(
            'TEL',
            $employee->getPhoneNumber(),
            ['type' => 'work'],
        );

        $vcard->add(
            'ADR',
            [
                '',
                '',
                'Avenue des Pâquis 31',
                'Morges',
                '',
                '1110',
                'Suisse',
            ],
            ['TYPE' => 'work'],
        );

        $vcard->add(
            'EMAIL',
            strtolower($employee->getEmail()),
            ['type' => 'work'],
        );

        return $vcard;
    }

}