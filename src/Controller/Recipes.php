<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Recipes extends AbstractController
{
    #[Route("/recipes", name: "app_all_recipes")]
    public function allRecipes(){
        return $this->render('recipes/recipes.html.twig',[
            'recipes' => "hello",
        ]);
    }
}