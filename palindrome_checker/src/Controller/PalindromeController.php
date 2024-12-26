<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PalindromeController extends AbstractController
{

    #[Route("/", name: "palindrome_checker")]

    public function palindrome(Request $request): Response
    {
         $word = $request->query->get("word", "");
        $palindrome =  $word === strrev($word);



        return $this->render(
            "palindrome/index.html.twig",
            ["palindrome" => $palindrome, "word" => $word]


        );
    }
}
