<?php

namespace App\Service;

use App\Entity\ExerciseLog;
use App\Repository\ExerciseLogRepository;

class ExerciseLogService
{
    public function __construct(private ExerciseLogRepository $exerciseLogRepository)
    {
    }

    public function saveExerciseLog(ExerciseLog $exerciseLog): void
    {
        $this->exerciseLogRepository->addExerciseLog($exerciseLog);
    }

}