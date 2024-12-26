<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StarshipRepository;

#[Route("/api/starships")]
class StarshipApiController extends AbstractController
{
    #[Route("", methods: ["GET"])]
    public function getCollection(StarshipRepository $repository): Response
    {


        $starShips = $repository->findAll();
        return $this->json($starShips);
    }
    #[Route("/{id<\d+>}", methods: ["GET"])]
    public function get(int $id, StarshipRepository $repository): Response
    {
        $starship = $repository->find($id);

        if (!$starship) {
            throw $this->createNotFoundException("starship not found");
        }

        return $this->json($starship);
    }
}
