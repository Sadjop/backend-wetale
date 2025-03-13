<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }


    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // Ce code ne sera jamais exécuté car Symfony gère la déconnexion automatiquement.
    }
}

