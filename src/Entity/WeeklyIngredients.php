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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Ingredients|null
     */
    public function getIngredient(): ?Ingredients
    {
        return $this->ingredient;
    }

    /**
     * @param Ingredients|null $ingredient
     */
    public function setIngredient(?Ingredients $ingredient): void
    {
        $this->ingredient = $ingredient;
    }

    /**
     * @return Recipes|null
     */
    public function getRecipe(): ?Recipes
    {
        return $this->recipe;
    }

    /**
     * @param Recipes|null $recipe
     */
    public function setRecipe(?Recipes $recipe): void
    {
        $this->recipe = $recipe;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     */
    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    #[ORM\ManyToOne(fetch:"EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    public ?Ingredients $ingredient = null;

    #[ORM\ManyToOne(fetch:"EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    public ?Recipes $recipe = null;

    #[ORM\Column]
    private ?float $amount = null;


}
