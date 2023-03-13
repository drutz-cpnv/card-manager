<?php

namespace App\Service;

use App\Data\VCardData;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Sabre\VObject\Component\VCard;
use Sabre\VObject\Document;
use Sabre\VObject\Property;

class VirtualCardService
{

    public function __construct(
        private EmployeeRepository $employeeRepository,
    )
    {}

    /**
     * Retourne un tableau avec comme clé `v_card`: `VCard::class` et `string`: `string`
     * @param VCardData $data
     * @return VCard
     */
    public function create(VCardData $data): VCard
    {
        $vcard = new VCard([
            'CLASS' => 'CONFIDENTIAL',
            'KIND'  => $data->getNameDisplayType() === VCardData::DISPLAY_MODE_PRM ? 'organization' : 'individual',
            'CATEGORIES' => [
                'Police'
            ],
            'ORG'   => [
                'Police Région Morges',
            ],
        ]);

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

        if($data->getNameDisplayType() === VCardData::DISPLAY_MODE_PRM) {
            $vcard->add(
                'TEL',
                '+41218111919',
                ['type' => 'work'],
            );

            $vcard->add(
                'EMAIL',
                'info@police-region-morges.ch',
                ['type' => 'work'],
            );

            return $vcard;
        }

        if($data->isDisplayRank()) {
            $vcard->add('TITLE', $data->getEmployee()->getRankValue(),);
        }
        if($data->isDisplayRole()) {
            $vcard->add('ROLE', $data->getEmployee()->getRoleValue());
        }
        
        $this->getName($vcard, $data);

        $vcard->add(
            'TEL',
            $data->getPhoneNumber(),
            ['type' => 'work'],
        );


        $vcard->add(
            'EMAIL',
            strtolower($data->getEmail()),
            ['type' => 'work'],
        );

        return $vcard;
    }

    private function getName(VCard $vcard, VCardData $data)
    {
        match ($data->getNameDisplayType()) {
            VCardData::DISPLAY_MODE_BADGE_NUMBER => $this->setBadgeNumberAsName($vcard, $data),
            VCardData::DISPLAY_MODE_ROLE => $this->setRoleAsName($vcard, $data),
            VCardData::DISPLAY_MODE_PRM => $this->setPRMAsName($vcard, $data),
            default => $this->setFullname($vcard, $data)
        };
    }

    public function setFullname(VCard $vcard, VCardData $data): void
    {
        $vcard->add('FN', (string)$data->getEmployee());
        $vcard->add('N', [
            $data->getEmployee()->getLastname(),
            $data->getEmployee()->getFirstname(),
            '',
            $data->getEmployee()->getRankAbbreviation()
        ]);
    }

    public function setBadgeNumberAsName(VCard $vcard, VCardData $data): void
    {
        $vcard->add('FN', 'PRM - ' . $data->getEmployee()->getBadgeNumber());
        $vcard->add('N', [
            $data->getEmployee()->getBadgeNumber(),
            'PRM',
            '',
            $data->isDisplayRank() ? $data->getEmployee()->getRankAbbreviation() : '',
        ]);
    }

    public function setRoleAsName(VCard $vcard, VCardData $data): void
    {
        $vcard->add('FN', 'PRM - ' . $data->getEmployee()->getRoleValue());
        $vcard->add('N', [
            $data->getEmployee()->getRoleValue(),
            'PRM',
            '',
            '',
        ]);
    }

    public function setPRMAsName(VCard $vcard, VCardData $data): void
    {
        $vcard->add('FN', 'Police Région Morges');
        $vcard->add('N', [
            '(Police Région Morges)',
            'PRM',
            '',
            '',
        ]);
    }

}