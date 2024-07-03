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
    public function index(Request $request, MuscleGroupRepository $muscleGroupRepository, MuscleGroupValidation $muscleGroupValidation): Response
    {

        $muscleGroup = new MuscleGroup();

        $form = $this->createForm(MuscleGroupType::class, $muscleGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $muscleGroup = $form->getData();

            if ($muscleGroupValidation->checkMuscleGroupExists($muscleGroup->getName())) {
                $this->addFlash('error', 'Muscle group already exists.');
                return $this->redirectToRoute('app_muscle_group');
            } else {
                $muscleGroupRepository->addMuscleGroup($muscleGroup);
                return $this->redirectToRoute('app_muscle_group');
            }
        }

        return $this->render('muscle_group/muscle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
