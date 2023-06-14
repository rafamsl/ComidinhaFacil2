<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Repository\IngredientsRepository;
use App\Repository\UserRepository;
use App\Repository\WeeklyIngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_USER")]
class WeeklyIngredientsController extends AbstractController
{
    #[Route("/weeklyIngredients", name:"app_viewWeeklyIngredients", methods:["GET"])]
    public function viewAllWeeklyIngredients(UserRepository $userRepository,WeeklyIngredientsRepository $weeklyIngredientsRepository){
        $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
        $weeklyIngredients = $weeklyIngredientsRepository->groceryList($user);
        return $this->render('ingredients/ingredients.html.twig',[
            'ingredients' => $weeklyIngredients,
        ]);
    }

    #[Route("/removeIngredient/{ingredientName}", name:"app_removeWeeklyIngredient", methods: ["GET"])]
    public function removeIngredient(string $ingredientName,IngredientsRepository $ingredientsRepository, WeeklyIngredientsRepository $weeklyIngredientsRepository){
        $ingredient = $ingredientsRepository->findBy(['name' => $ingredientName]);

        if(!$ingredient[0] instanceof Ingredients){
            $this->addFlash("error","ingredient not found");
            return new RedirectResponse("/weeklyIngredients");
        }
        $weeklyIngredients = $weeklyIngredientsRepository->findBy(['ingredient'=>$ingredient]);
        foreach ($weeklyIngredients as $weeklyIngredient){
            $weeklyIngredientsRepository->remove($weeklyIngredient, true);
        }
        $this->addFlash("success","ingredient removed");
        return new RedirectResponse("/weeklyIngredients");

    }

}