<?php

namespace App\Repository;

use App\DTO\WeeklyIngredientDTO;
use App\Entity\Recipes;
use App\Entity\WeeklyIngredients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WeeklyIngredients>
 *
 * @method WeeklyIngredients|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeeklyIngredients|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeeklyIngredients[]    findAll()
 * @method WeeklyIngredients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeeklyIngredientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeeklyIngredients::class);
    }

    public function save(WeeklyIngredients $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WeeklyIngredients $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /** @noinspection DuplicatedCode */
    public function buildFromRecipe(Recipes $recipe): void
    {
        $recipeIngredients = $recipe->getRecipeIngredients();

        foreach ($recipeIngredients as $recipeIngredient){
            $newWeeklyIngredient = new WeeklyIngredients();
            $newWeeklyIngredient->setIngredient($recipeIngredient->getIngredient());
            $newWeeklyIngredient->setRecipe($recipe);
            $newWeeklyIngredient->setAmount($recipeIngredient->getAmount());
            $this->save($newWeeklyIngredient);
        }
        $this->getEntityManager()->flush();
    }

    public function removeFromRecipe(Recipes $recipe): void
    {
        $weeklyIngredients = $this->findBy(['recipe'=>$recipe]);

        foreach ($weeklyIngredients as $weeklyIngredient){
            $this->remove($weeklyIngredient);
        }
        $this->getEntityManager()->flush();
    }

    public function groceryList(): ArrayCollection
    {
        $weeklyIngredientsResponse = new ArrayCollection();
        $weeklyIngredients = $this->findAll();

        foreach ($weeklyIngredients as $weeklyIngredient){
            $ingredientName = $weeklyIngredient->getIngredient()->getName();
            $existingIngredientDTO = $weeklyIngredientsResponse->get($ingredientName);
            if ($existingIngredientDTO) {
                $existingIngredientDTO->amount += $weeklyIngredient->getAmount();
                $existingIngredientDTO->recipes[] = $weeklyIngredient->getRecipe();
            } else {
                $weeklyIngredientDTO = new WeeklyIngredientDTO($weeklyIngredient);
                $weeklyIngredientsResponse->set($ingredientName, $weeklyIngredientDTO);
            }
        }
        return $weeklyIngredientsResponse;
    }

//    /**
//     * @return WeeklyIngredients[] Returns an array of WeeklyIngredients objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WeeklyIngredients
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
