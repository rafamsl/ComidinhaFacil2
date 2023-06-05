<?php

namespace App\Entity;

use App\Repository\WeeklyIngredientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeeklyIngredientsRepository::class)]
class WeeklyIngredients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'weeklyIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeeklyRecipes $weeklyRecipe = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?RecipeIngredients $recipeIngredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeeklyRecipe(): ?WeeklyRecipes
    {
        return $this->weeklyRecipe;
    }

    public function setWeeklyRecipe(?WeeklyRecipes $weeklyRecipe): self
    {
        $this->weeklyRecipe = $weeklyRecipe;

        return $this;
    }

    public function getRecipeIngredient(): ?RecipeIngredients
    {
        return $this->recipeIngredient;
    }

    public function setRecipeIngredient(?RecipeIngredients $recipeIngredient): self
    {
        $this->recipeIngredient = $recipeIngredient;

        return $this;
    }
}
