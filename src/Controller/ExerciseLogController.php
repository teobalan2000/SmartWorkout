<?php

namespace App\Controller;

use App\Entity\ExerciseLog;
use App\Form\ExerciseLogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseLogController extends AbstractController
{
    #[Route('/exercise/log', name: 'app_exercise_log')]
    public function store(Request $request): Response
    {
        $exerciseLog = new ExerciseLog();

        $form = $this->createForm(ExerciseLogType::class, $exerciseLog);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exerciseLog = $form->getData();
        }

        return $this->render('exercise_log/index.html.twig', [
            'controller_name' => 'ExerciseLogController',
        ]);
    }
}
