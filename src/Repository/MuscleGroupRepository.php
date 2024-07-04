<?php

namespace App\Repository;

use App\Entity\MuscleGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MuscleGroup>
 */
class MuscleGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MuscleGroup::class);
    }

    public function addMuscleGroup(MuscleGroup $muscleGroup): void
    {
        $this->getEntityManager()->persist($muscleGroup);
        $this->getEntityManager()->flush();
    }

    public function displayMuscles(): array
    {
        return $this->findAll();
    }

    public function deleteMuscle(int $id): void
    {
        $existingMuscle = $this->find($id);
        if(!is_null($existingMuscle))
        {
            $this->getEntityManager()->remove($existingMuscle);
            $this->getEntityManager()->flush();
        }

    }

}
