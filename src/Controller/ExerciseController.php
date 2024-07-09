<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\ExerciseType;
use App\Repository\ExerciseRepository;
use App\Service\ExerciseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    #[Route('/exercises', name: 'app_exercise')]
    public function store(Request $request, ExerciseService $exerciseService): Response
    {
        $exercise = new Exercise();

        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();

            $status = $exerciseService->addExercise($exercise);

            if(array_key_exists('status', $status)){
                $this->addFlash('success', $status['message']);
                return $this->redirectToRoute('app_exercise');
            } else {
                $this->addFlash('error', $status['message']);
                return $this->redirectToRoute('app_exercise');
            }
        }

        return $this->render('exercise/exercises.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/exercise/exercisesList', name: 'display_exercises')]
    public function display(ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->displayExercises();

        return $this->render('exercise/exercisesList.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/exercise/{id}', name: 'edit_exercise')]
    public function update(Request $request, ExerciseService $exerciseService, $id)
    {
        $exercise = $exerciseService->getExerciseById($id);

        $form = $this->createForm(ExerciseType::class, $exercise);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();

            $status = $exerciseService->updateExercise($exercise);

            if(array_key_exists('status', $status)){
                $this->addFlash('success', $status['message']);
                return $this->redirectToRoute('edit_exercise', ['id' => $id]);
            } else {
                $this->addFlash('error', $status['message']);
                return $this->redirectToRoute('edit_exercise', ['id' => $id]);
            }

        }

        return $this->render('exercise/exercises.html.twig', [
            'form' => $form->createView(),
            'exerciseId' => $id,
        ]);
    }

    #[Route('/exercises/{id}', name: 'delete_exercise', methods: ['DELETE'])]
    public function destroy(ExerciseService $exerciseService, $id)
    {
        $exerciseService->deleteExercise($id);
        return $this->redirectToRoute('display_exercises');
    }


}
