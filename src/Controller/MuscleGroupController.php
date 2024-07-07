<?php

namespace App\Controller;

use App\Entity\MuscleGroup;
use App\Form\MuscleGroupType;
use App\Repository\MuscleGroupRepository;
use App\Service\MuscleGroupValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MuscleGroupController extends AbstractController
{
    #[Route('/muscle', name: 'app_muscle_group')]
    public function store(Request $request, MuscleGroupValidation $muscleGroupValidation): Response
    {

        $muscleGroup = new MuscleGroup();

        $form = $this->createForm(MuscleGroupType::class, $muscleGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $muscleGroup = $form->getData();

            $status = $muscleGroupValidation->addMuscleGroup($muscleGroup);

            if(array_key_exists('status', $status)){
                $this->addFlash('success', $status['message']);
                return $this->redirectToRoute('app_muscle_group');
            } else {
                $this->addFlash('error', $status['message']);
                return $this->redirectToRoute('app_muscle_group');
            }

//            if ($muscleGroupValidation->checkMuscleGroupExists($muscleGroup->getName())) {
//                $this->addFlash('error', 'Muscle group already exists.');
//                return $this->redirectToRoute('app_muscle_group');
//            } else {
//                $muscleGroupRepository->addMuscleGroup($muscleGroup);
//                return $this->redirectToRoute('app_muscle_group');
//            }
        }

        return $this->render('muscle_group/muscle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/muscleList', name: 'display_muscles')]
    public function display(MuscleGroupRepository $muscleGroupRepository): Response
    {
        $muscles = $muscleGroupRepository->displayMuscles();

        return $this->render('muscle_group/muscleList.html.twig', [
            'muscles' => $muscles,
        ]);
    }

    #[Route('/muscle/{id}/muscleExercises', name: 'show_exercises', methods: ['GET'])]
    public function show(MuscleGroupRepository $muscleGroupRepository, $id): Response
    {
        $muscleGroup = $muscleGroupRepository->find($id);

        $exercises = $muscleGroup->getExercises();

        return $this->render('muscle_group/muscleExercises.html.twig', [
            'muscleGroup' => $muscleGroup,
            'exercises' => $exercises,
        ]);
    }

    #[Route('/muscle/{id}', name: 'delete_muscle', methods: ['DELETE'])]
    public function destroy(Request $request, MuscleGroupValidation $muscleGroupValidation, $id)
    {
        $muscleGroupValidation->deleteMuscle($id);
        return $this->redirectToRoute('display_muscles');
    }


}
