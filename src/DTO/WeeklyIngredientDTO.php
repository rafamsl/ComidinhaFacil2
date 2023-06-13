<?php

namespace App\DTO;

use App\Entity\WeeklyIngredients;

class WeeklyIngredientDTO
{
    public $name;
    public $amount;
    public $unit;
    public $recipes = [];

    public function __construct(WeeklyIngredients $weeklyIngredient){
        $this->name = $weeklyIngredient->getIngredient()->getName();
        $this->amount = $weeklyIngredient->getAmount();
        $this->unit = $weeklyIngredient->getIngredient()->getUnit();
        $this->recipes[] = $weeklyIngredient->getRecipe();

    }


}