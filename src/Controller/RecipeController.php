<?php

namespace App\Controller;

use App\DTO\RecipeDTO;
use App\DTO\RecipeResponseDTO;
use App\Entity\Recipes;
use App\Repository\IngredientsRepository;
use App\Repository\RecipesRepository;
use App\Repository\WeeklyRecipesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route("/recipes", name: "app_recipes")]
    public function allRecipes(RecipesRepository $recipesRepository, WeeklyRecipesRepository $weeklyRecipesRepository){
        $recipes = $recipesRepository->findBy(['status' => 0]);
        $weeklyRecipes = $weeklyRecipesRepository->findAll();
        return $this->render('recipes/recipes.html.twig',[
            'recipes' => $recipes,
            'weeklyRecipes' => $weeklyRecipes,
        ]);
    }
    #[Route("/addRecipe", name: "app_viewAddRecipe", methods: ["GET"])]
    public function viewAddRecipe(RecipesRepository $recipesRepository){
        return $this->render('recipes/addRecipe.html.twig');
    }

    #[Route("/addRecipe", name: "app_addRecipe", methods: ["POST"])]
    public function addRecipe(Request $request, RecipesRepository $recipesRepository, IngredientsRepository $ingredientsRepository): RedirectResponse
    {
        $newRecipeRequest = $request->request->all();
        $newRecipeDTO = new RecipeDTO(
            $newRecipeRequest['recipe_name'],
            $newRecipeRequest['recipe_description']);
        $newRecipe = $recipesRepository->buildFromDTO($newRecipeDTO);

        $ingredientsRepository->buildFromArray($newRecipeRequest['ingredient'],$newRecipe);

        return new RedirectResponse("/recipes");

    }

    #[Route("/removeRecipe/{recipeId}", name:"app_removeRecipe", methods: ["GET"])]
    public function removeRecipe(int $recipeId, RecipesRepository $recipesRepository): RedirectResponse
    {
        $recipe = $recipesRepository->find($recipeId);
        $recipesRepository->remove($recipe, true);

        $this->addFlash('success', 'Recipe deleted');
        return new RedirectResponse("/recipes");
    }

    #[Route("/addRecipeWeekly/{recipeId}", name:"app_addRecipeWeekly", methods: ["GET"])]
    public function addRecipeToWeekly(int $recipeId,RecipesRepository $recipesRepository, WeeklyRecipesRepository $weeklyRecipesRepository){
        $addRecipe = $recipesRepository->find($recipeId);

        //check if recipe exists
        if(!$addRecipe instanceof Recipes){
            $this->addFlash('error', 'Recipe not found!');
            return new RedirectResponse('/recipes');
        }

        # Check if Recipe was in this list
        if($addRecipe->getStatus() === 1){
            $this->addFlash('error', 'Recipe already on the list!');
            return new RedirectResponse('/recipes');
        }

        $recipesRepository->setStatus(1,$addRecipe);
        $weeklyRecipesRepository->buildFromRecipe($addRecipe);

        $this->addFlash('success', 'Recipe added!');
        return new RedirectResponse('/recipes');
    }

    #[Route("/removeRecipeWeekly/{recipeId}", name:"app_removeRecipeWeekly", methods: ["GET"])]
    public function removeRecipeWeekly(int $recipeId, RecipesRepository $recipesRepository, WeeklyRecipesRepository $weeklyRecipesRepository){
        $removeRecipe = $recipesRepository->find($recipeId);

        //check if recipe exists
        if(!$removeRecipe instanceof Recipes){
            $this->addFlash('error', 'Recipe not found!');
            return new RedirectResponse('/recipes');
        }

        $weeklyRecipe = $weeklyRecipesRepository->findOneBy(['recipe' => $removeRecipe->getId()]);
        # Check if Recipe was in this list
        if($removeRecipe->getStatus() === 0){
            $this->addFlash('error', 'Recipe was not on the list!');
            return new RedirectResponse('/recipes');
        }

        $recipesRepository->setStatus(0,$removeRecipe);
        $weeklyRecipesRepository->remove($weeklyRecipe, true);

        $this->addFlash('success', 'Recipe removed from the list!');
        return new RedirectResponse('/recipes');
    }

    #[Route("/viewRecipe/{recipeId}", name: "app_viewRecipe", methods: ["GET"])]
    public function viewRecipe(int $recipeId, RecipesRepository $recipesRepository){
        $recipe = $recipesRepository->find($recipeId);

        $recipeResponseDTO = new RecipeResponseDTO($recipe);

        return $this->render("recipes/viewRecipe.html.twig",[
            'recipe'=>$recipeResponseDTO,
        ]);

    }
}