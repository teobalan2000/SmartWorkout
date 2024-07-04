<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercise>
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    public function addExercise(Exercise $exercise)
    {
        $this->getEntityManager()->persist($exercise);
        $this->getEntityManager()->flush();
    }

    public function displayExercises()
    {
        return $this->findAll();
    }

    public function deleteExercise(int $id)
    {
        $existingExercise = $this->find($id);
        if(!is_null($existingExercise))
        {
            $this->getEntityManager()->remove($existingExercise);
            $this->getEntityManager()->flush();
        }

    }

    /**
     * @return Exercise|null Returns an Exercise object or null
     */
        public function checkIfExerciseExists($name, $id): ?Exercise
        {
            return $this->createQueryBuilder('e')
                ->where('e.name = :name')
                ->andWhere('e.id != :id')
                ->setParameter('name', $name)
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Exercise
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
