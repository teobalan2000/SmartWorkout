<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/register', name: 'register_user')]
    public function store(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            $user = $form->getData();
            $password = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);

            $userRepository->saveUser($user);
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/user/users', name: 'display_users')]
    public function display(UserRepository $userRepository): Response
    {
        $users = $userRepository->displayAllUsers();

        return $this->render('user/users.html.twig', [
            'users' => $users,
        ]);
    }
}
