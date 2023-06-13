<?php

namespace App\DTO;

use App\Entity\Recipes;

class RecipeResponseDTO
{
    public string $name;
    public string $description;
    public int $status;
    public \Doctrine\Common\Collections\Collection $ingredients;

    public function __construct(Recipes $recipe){
        $this->name = $recipe->getName();
        $this->description = $recipe->getDescription();
        $this->status = $recipe->getStatus();
        $this->ingredients = $recipe->getRecipeIngredients();

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @param array $ingredients
     */
    public function setIngredients(array $ingredients): void
    {
        $this->ingredients = $ingredients;
    }



}