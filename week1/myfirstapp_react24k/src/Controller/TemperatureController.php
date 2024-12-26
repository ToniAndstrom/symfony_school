<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class TemperatureController extends AbstractController
{
    #[Route("/temp", name: "temperature_convertor")]
    public function temperature(Request $request)
    {
        $temp = $request->query->get("temperature");
        if (!is_numeric($temp)) {
            return new Response("Error: Temperature must be a number", 400);
        }
        $fahrenheit = ($temp * 9 / 5) + 32;
        $celsius = ($temp-32)/1.8;

        return new Response($temp . " Celsius in Fahrenheit: " . $fahrenheit . " and " .$temp ." Fahrenheit in Celsius:" . $celsius);
    }
}
