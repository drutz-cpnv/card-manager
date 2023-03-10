<?php

namespace App\Data;

use App\Entity\Employee;

class VCardData
{
    const DISPLAY_MODE_FULLNAME = 1;
    const DISPLAY_MODE_BADGE_NUMBER = 2;
    const DISPLAY_MODE_ROLE = 3;
    const DISPLAY_MODE_PRM = 4;

    private array $displayModeChoices = [];

    private int $nameDisplayType = 0;
    private bool $displayRole = true;
    private bool $displayRank = true;
    private ?string $phoneNumber = null;
    private ?string $email = null;
    private ?Employee $employee = null;

    public static function createFromEmployee(Employee $employee): self
    {
        return (new VCardData())
            ->setEmail($employee->getEmail())
            ->setPhoneNumber($employee->getPhoneNumber())
            ->setDisplayModeChoices([
                self::DISPLAY_MODE_FULLNAME => "Nom complet ({$employee->getFullname()})",
                self::DISPLAY_MODE_BADGE_NUMBER => "Matricule (uniquement personnel Police, ASP et UAAE)",
                self::DISPLAY_MODE_ROLE => "Fonction",
                self::DISPLAY_MODE_PRM => "Police Région Morges"
            ])
            ->setEmployee($employee)
        ;
    }

    /**
     * @return array
     */
    public function getDisplayModeChoices(): array
    {
        return $this->displayModeChoices;
    }

    /**
     * @param array $displayModeChoices
     * @return VCardData
     */
    public function setDisplayModeChoices(array $displayModeChoices): VCardData
    {
        $this->displayModeChoices = $displayModeChoices;
        return $this;
    }

    /**
     * @return int
     */
    public function getNameDisplayType(): int
    {
        return $this->nameDisplayType;
    }

    /**
     * @param int $nameDisplayType
     * @return VCardData
     */
    public function setNameDisplayType(int $nameDisplayType): VCardData
    {
        $this->nameDisplayType = $nameDisplayType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisplayRole(): bool
    {
        return $this->displayRole;
    }

    /**
     * @param bool $displayRole
     * @return VCardData
     */
    public function setDisplayRole(bool $displayRole): VCardData
    {
        $this->displayRole = $displayRole;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisplayRank(): bool
    {
        return $this->displayRank;
    }

    /**
     * @param bool $displayRank
     * @return VCardData
     */
    public function setDisplayRank(bool $displayRank): VCardData
    {
        $this->displayRank = $displayRank;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     * @return VCardData
     */
    public function setPhoneNumber(?string $phoneNumber): VCardData
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return VCardData
     */
    public function setEmail(?string $email): VCardData
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Employee|null
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee|null $employee
     * @return VCardData
     */
    public function setEmployee(?Employee $employee): VCardData
    {
        $this->employee = $employee;
        return $this;
    }






}