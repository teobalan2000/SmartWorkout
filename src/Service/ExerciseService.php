<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;

class ExerciseService
{
    public function __construct(private ExerciseRepository $exerciseRepository)
    {
    }

    public function getExerciseById($exerciseId): object
    {
        return $this->exerciseRepository->find($exerciseId);
    }
    public function addExercise(Exercise $exercise): array
    {
        try{
            $existingExercise = $this->exerciseRepository->findOneBy(['name' => $exercise->getName()]);

            if($existingExercise)
            {
                throw new \Exception("Exercise already exists");
            }
            $this->exerciseRepository->addExercise($exercise);

            return ['success' => true, 'message' => 'Exercise added successfully'];
        }catch (\Exception $exception){
            return['error' => true, 'message' => $exception->getMessage()];
        }
    }

    public function updateExercise(Exercise $exercise): array
    {
        $existingExercise = $this->exerciseRepository->checkIfExerciseExists($exercise->getName(), $exercise->getId());

        if($existingExercise)
        {
            return ['error' => true, 'message' => 'An exercise with this name already exists.'];
        }

        $this->exerciseRepository->addExercise($exercise);

        return ['success' => true, 'message' => 'Exercise updated successfully'];
    }

    public function deleteExercise($id)
    {
        $this->exerciseRepository->deleteExercise($id);
    }
}