<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function allUsers(): Response
    {
        return $this->render('users/index.html.twig');
    }

    #[Route('/user', name: 'app_user')]
    public function addUser(UserRepository $repo): Response
    {
        $repo->addUser();
        return $this->render('user/index.html.twig');
    }
}
