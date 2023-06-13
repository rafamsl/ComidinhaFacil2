<?php

namespace App\Repository;

use App\Entity\Recipes;
use App\Entity\WeeklyRecipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WeeklyRecipes>
 *
 * @method WeeklyRecipes|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeeklyRecipes|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeeklyRecipes[]    findAll()
 * @method WeeklyRecipes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeeklyRecipesRepository extends ServiceEntityRepository
{
    public WeeklyIngredientsRepository $weeklyIngredientsRepository;

    public function __construct(ManagerRegistry $registry, WeeklyIngredientsRepository $weeklyIngredientsRepository)
    {
        parent::__construct($registry, WeeklyRecipes::class);
        $this->weeklyIngredientsRepository = $weeklyIngredientsRepository;
    }

    public function save(WeeklyRecipes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WeeklyRecipes $entity, bool $flush = false): void
    {
        //remove ingredients
        $this->weeklyIngredientsRepository->removeFromRecipe($entity->getRecipe());

        //remove recipe
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function buildFromRecipe(Recipes $recipe): Recipes
    {
        $newWeeklyRecipe = new WeeklyRecipes();
        $newWeeklyRecipe->setRecipe($recipe);
        $this->save($newWeeklyRecipe,true);

        // Add ingredients
        $this->weeklyIngredientsRepository->buildFromRecipe($recipe);

        return $newWeeklyRecipe->getRecipe();
    }

//    /**
//     * @return WeeklyRecipes[] Returns an array of WeeklyRecipes objects
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

//    public function findOneBySomeField($value): ?WeeklyRecipes
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
