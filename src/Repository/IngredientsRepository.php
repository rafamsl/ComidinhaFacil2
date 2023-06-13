<?php

namespace App\Repository;

use App\DTO\IngredientDTO;
use App\DTO\RecipeIngredientDTO;
use App\Entity\Ingredients;
use App\Entity\Recipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredients>
 *
 * @method Ingredients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingredients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingredients[]    findAll()
 * @method Ingredients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientsRepository extends ServiceEntityRepository
{
    public RecipeIngredientsRepository $recipeIngredientsRepository;

    public function __construct(ManagerRegistry $registry, RecipeIngredientsRepository $recipeIngredientsRepository)
    {
        parent::__construct($registry, Ingredients::class);
        $this->recipeIngredientsRepository = $recipeIngredientsRepository;
    }

    public function save(Ingredients $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ingredients $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function buildFromArray(array $ingredients, Recipes $recipe){
        foreach ($ingredients as $recipeIngredient){
            $ingredient = $this->findOneBy(['name'=>$recipeIngredient['name']]);
            if (!$ingredient instanceof Ingredients){
                $ingredientDTO = new IngredientDTO($recipeIngredient['name'], $recipeIngredient['unit']);
                $ingredient = $this->buildFromDTO($ingredientDTO);
            }

            $newRecipeIngredientDTO = new RecipeIngredientDTO($recipe, $ingredient,$recipeIngredient['amount']);
            $this->recipeIngredientsRepository->buildFromDTO($newRecipeIngredientDTO);
        }
    }

    public function buildFromDTO(IngredientDTO $ingredientDTO): Ingredients
    {
        $ingredient = new Ingredients();
        $ingredient->setName($ingredientDTO->name);
        $ingredient->setUnit($ingredientDTO->unit);

        $this->save($ingredient, true);

        return $ingredient;
    }

//    /**
//     * @return Ingredients[] Returns an array of Ingredients objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ingredients
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
