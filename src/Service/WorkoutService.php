<?php

namespace App\Service;

use App\Entity\Workout;
use App\Repository\WorkoutRepository;

class WorkoutService
{

    public function __construct(private WorkoutRepository $workoutRepository)
    {
    }
    public function saveWorkout(Workout $workout)
    {
        $this->workoutRepository->addWorkout($workout);
    }

    public function deleteWorkout($id): void
    {
        $this->workoutRepository->deleteWorkout($id);
    }
}