<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Form\WorkoutType;
use App\Repository\WorkoutRepository;
use App\Service\WorkoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class WorkoutController extends AbstractController
{
    #[Route('/workout', name: 'app_workout')]
    public function store(Request $request, WorkoutService $workoutService, UserInterface $user): Response
    {

        $workout = new Workout();

        $form = $this->createForm(WorkoutType::class, $workout);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $workout = $form->getData();
            $workout->setPerson($user);
            $workoutService->saveWorkout($workout);

            return $this->redirectToRoute('app_workout');
        }

        return $this->render('workout/workout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/workoutsList', name: 'display_workouts')]
    public function display(WorkoutRepository $workoutRepository): Response
    {
        $user = $this->getUser();

        $workouts = $workoutRepository->findBy(['person' => $user]);

        return $this->render('workout/workoutsList.html.twig', [
            'workouts' => $workouts,
        ]);
    }

    #[Route('/workout/{id}/workoutExercises', name: 'show_exercises_log', methods: ['GET'])]
    public function show(WorkoutRepository $workoutRepository, $id): Response
    {
        $workout = $workoutRepository->find($id);

        $exercises = $workout->getExerciseLogs();

        return $this->render('workout/workoutExercises.html.twig', [
            'workout' => $workout,
            'exercises' => $exercises,
        ]);
    }

    #[Route('/workoutsList/{id}', name: 'delete_workout', methods: ['DELETE'])]
    public function destroy(Request $request, WorkoutService $workoutService, $id)
    {
        $workoutService->deleteWorkout($id);
        return $this->redirectToRoute('display_workouts');
    }
}
