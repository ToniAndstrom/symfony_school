<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriberController extends AbstractController
{
    #[Route('/', name: 'app_subscriber')]
    public function show(Request $request, EntityManagerInterface $em)
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberFormType::class, $subscriber);

        $form->handleRequest($request);

        $agreeTerms = $form->get("agreeTerms")->getData();

        if ($form->isSubmitted() && $form->isValid() && $agreeTerms) {

            $em->persist($subscriber);
            $em->flush();

            return new Response("Subscriber number " . $subscriber->getId() . " created...");
        }

        return $this->render('subscriber/show.html.twig', [
            "subscriber_form" => $form->createView()
        ]);
    }
}
