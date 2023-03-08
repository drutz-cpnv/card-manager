<?php

namespace App\Data;

class RankData
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
     * @return RankData
     */
    public function setName(?string $name): RankData
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
     * @return RankData
     */
    public function setNonDefined(?string $nonDefined): RankData
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
     * @return RankData
     */
    public function setFemale(?string $female): RankData
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
     * @return RankData
     */
    public function setMale(?string $male): RankData
    {
        $this->male = $male;
        return $this;
    }



}