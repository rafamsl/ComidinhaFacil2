<?php

namespace App\Entity;

use App\Repository\WeeklyRecipesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeeklyRecipesRepository::class)]
class WeeklyRecipes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipes $recipe = null;

    #[ORM\OneToMany(mappedBy: 'weeklyRecipe', targetEntity: WeeklyIngredients::class, orphanRemoval: true)]
    private Collection $weeklyIngredients;

    public function __construct()
    {
        $this->weeklyIngredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipes
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipes $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Collection<int, WeeklyIngredients>
     */
    public function getWeeklyIngredients(): Collection
    {
        return $this->weeklyIngredients;
    }

    public function addWeeklyIngredient(WeeklyIngredients $weeklyIngredient): self
    {
        if (!$this->weeklyIngredients->contains($weeklyIngredient)) {
            $this->weeklyIngredients->add($weeklyIngredient);
            $weeklyIngredient->setWeeklyRecipe($this);
        }

        return $this;
    }

    public function removeWeeklyIngredient(WeeklyIngredients $weeklyIngredient): self
    {
        if ($this->weeklyIngredients->removeElement($weeklyIngredient)) {
            // set the owning side to null (unless already changed)
            if ($weeklyIngredient->getWeeklyRecipe() === $this) {
                $weeklyIngredient->setWeeklyRecipe(null);
            }
        }

        return $this;
    }
}
