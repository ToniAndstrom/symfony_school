<?php

namespace App\Controller;

use App\Entity\Itinerary;
use App\Form\ItineraryType;
use App\Repository\ItineraryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CallApiService;

#[Route('/itinerary')]
class ItineraryController extends AbstractController
{

    #[Route('/', name: 'app_itinerary_index', methods: ['GET'])]
    public function index(ItineraryRepository $itineraryRepository): Response
    {
        return $this->render('itinerary/index.html.twig', [
            'itineraries' => $itineraryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_itinerary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itinerary = new Itinerary();
        $form = $this->createForm(ItineraryType::class, $itinerary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itinerary);
            $entityManager->flush();

            return $this->redirectToRoute('app_itinerary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('itinerary/new.html.twig', [
            'itinerary' => $itinerary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_itinerary_show', methods: ['GET'])]
    public function show(Itinerary $itinerary): Response
    {
        return $this->render('itinerary/show.html.twig', [
            'itinerary' => $itinerary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_itinerary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Itinerary $itinerary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItineraryType::class, $itinerary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_itinerary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('itinerary/edit.html.twig', [
            'itinerary' => $itinerary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_itinerary_delete', methods: ['POST'])]
    public function delete(Request $request, Itinerary $itinerary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itinerary->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($itinerary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_itinerary_index', [], Response::HTTP_SEE_OTHER);
    }
}
