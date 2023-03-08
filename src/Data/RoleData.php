<?php

namespace App\Data;

class RoleData
{

    private ?string $name = null;
    private ?string $nonDefined = null;
    private ?string $female = null;
    private ?string $male = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return RoleData
     */
    public function setName(?string $name): RoleData
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNonDefined(): ?string
    {
        return $this->nonDefined;
    }

    /**
     * @param string|null $nonDefined
     * @return RoleData
     */
    public function setNonDefined(?string $nonDefined): RoleData
    {
        $this->nonDefined = $nonDefined;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFemale(): ?string
    {
        return $this->female;
    }

    /**
     * @param string|null $female
     * @return RoleData
     */
    public function setFemale(?string $female): RoleData
    {
        $this->female = $female;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMale(): ?string
    {
        return $this->male;
    }

    /**
     * @param string|null $male
     * @return RoleData
     */
    public function setMale(?string $male): RoleData
    {
        $this->male = $male;
        return $this;
    }



}