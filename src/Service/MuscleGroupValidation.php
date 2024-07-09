<?php

namespace App\Service;

use App\Entity\MuscleGroup;
use App\Repository\MuscleGroupRepository;

class MuscleGroupValidation
{
    public function __construct(private MuscleGroupRepository $muscleGroupRepository)
    {
    }

//    public function checkMuscleGroupExists(string $name): bool
//    {
//        $muscleGroup = $this->muscleGroupRepository->findOneBy(['name' => $name]);
//
//        if ($muscleGroup) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    public function addMuscleGroup(MuscleGroup $muscleGroup): array
    {
        try{
            $existingMuscleGroup = $this->muscleGroupRepository->findOneBy(['name' => $muscleGroup->getName()]);

            if($existingMuscleGroup)
            {
                throw new \Exception("Muscle Group already exists");
            }
            $this->muscleGroupRepository->addMuscleGroup($muscleGroup);

            return ['success' => true, 'message' => 'Muscle Group added successfully'];
        }catch (\Exception $exception){
            return['error' => true, 'message' => $exception->getMessage()];
        }
    }

    public function getMuscleById($muscleId): object
    {
        return $this->muscleGroupRepository->find($muscleId);
    }

    public function updateMuscleGroup(MuscleGroup $muscleGroup): array
    {
        $existingMuscleGroup = $this->muscleGroupRepository->checkIfMuscleExists($muscleGroup->getName(), $muscleGroup->getId());

        if($existingMuscleGroup)
        {
            return ['error' => true, 'message' => 'A Muscle Group with this name already exists.'];
        }


        $this->muscleGroupRepository->addMuscleGroup($muscleGroup);

        return ['success' => true, 'message' => 'Muscle Group updated successfully'];
    }

    public function deleteMuscle($id): void
    {
        $this->muscleGroupRepository->deleteMuscle($id);
    }
}