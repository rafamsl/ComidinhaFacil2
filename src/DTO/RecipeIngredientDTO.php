<?php

namespace App\DTO;

use App\Entity\Ingredients;
use App\Entity\Recipes;

class RecipeIngredientDTO
{
    public Recipes $recipe;
    public Ingredients $ingredient;
    public float $amount;

    public function __construct(Recipes $recipe, Ingredients $ingredient, float $amount){
        $this->ingredient = $ingredient;
        $this->recipe = $recipe;
        $this->amount = $amount;
    }

    /**
     * @return Recipes
     */
    public function getRecipe(): Recipes
    {
        return $this->recipe;
    }

    /**
     * @param Recipes $recipe
     */
    public function setRecipe(Recipes $recipe): void
    {
        $this->recipe = $recipe;
    }

    /**
     * @return Ingredients
     */
    public function getIngredient(): Ingredients
    {
        return $this->ingredient;
    }

    /**
     * @param Ingredients $ingredient
     */
    public function setIngredient(Ingredients $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }


}