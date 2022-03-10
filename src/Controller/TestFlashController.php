<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestFlashController extends AbstractController
{
    #[Route('/test/flash', name: 'app_test_flash')]
    public function index(): Response
    {
        $this->addFlash("success", "Mon test flash !!!!!!!!");
        return $this->render('test_flash/index.html.twig', [
            'controller_name' => 'TestFlashController',
        ]);
    }
}
