<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CallApiService;

class Formula1Controller extends AbstractController
{
    #[Route('/', name: 'app_formula1')]
    public function index(CallApiService $callApiService): Response
    {
        dump($callApiService->getRacesIn2024());
        return $this->render('formula1/index.html.twig', [
            "data" =>$callApiService->getRacesIn2024()
        ]);
    }
}
