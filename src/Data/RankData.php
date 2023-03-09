<?php

namespace App\Data;

class RankData
{

    private ?string $name = null;
    private ?string $nonDefined = null;
    private ?string $abrNonDefined = null;
    private ?string $female = null;
    private ?string $abrFemale = null;
    private ?string $male = null;
    private ?string $abrMale = null;


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

    /**
     * @return string|null
     */
    public function getAbrNonDefined(): ?string
    {
        return $this->abrNonDefined;
    }

    /**
     * @param string|null $abrNonDefined
     * @return RankData
     */
    public function setAbrNonDefined(?string $abrNonDefined): RankData
    {
        $this->abrNonDefined = $abrNonDefined;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbrFemale(): ?string
    {
        return $this->abrFemale;
    }

    /**
     * @param string|null $abrFemale
     * @return RankData
     */
    public function setAbrFemale(?string $abrFemale): RankData
    {
        $this->abrFemale = $abrFemale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbrMale(): ?string
    {
        return $this->abrMale;
    }

    /**
     * @param string|null $abrMale
     * @return RankData
     */
    public function setAbrMale(?string $abrMale): RankData
    {
        $this->abrMale = $abrMale;
        return $this;
    }




}