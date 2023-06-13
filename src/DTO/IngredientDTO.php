<?php

namespace App\DTO;

class IngredientDTO
{
    public string $name;

    public string $unit;

    public function __construct(string $name, string $unit){
        $this->name = $name;
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

}