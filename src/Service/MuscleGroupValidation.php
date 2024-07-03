<?php

namespace App\Service;

use App\Repository\MuscleGroupRepository;

class MuscleGroupValidation
{
    public function __construct(private MuscleGroupRepository $muscleGroupRepository)
    {
    }

    public function checkMuscleGroupExists(string $name): bool
    {
        $muscleGroup = $this->muscleGroupRepository->findOneBy(['name' => $name]);

        if ($muscleGroup) {
            return true;
        } else {
            return false;
        }
    }
}